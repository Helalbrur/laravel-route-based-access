<?php
namespace App\Imports;

use App\Models\LibUom;
use App\Models\Company;
use App\Models\LibSize;
use App\Models\LibBrand;
use App\Models\LibColor;
use App\Models\LibGeneric;
use App\Models\LibCategory;
use App\Models\LibSupplier;
use App\Models\LibItemGroup;
use App\Models\LibItemSubCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public $importedCount = 0;
    public $skippedRows = [];
    private $prefixCache = [];
    private $lastItemCodes = [];
    private $referenceCache = [];

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        $this->skippedRows = [];
        $rowNumber = 1;
        $validRows = [];

        try {
            foreach ($rows as $row) {
                $rowNumber++;
                $rowData = $this->processRow($row, $rowNumber);
                
                if ($rowData['valid']) {
                    $validRows[] = $rowData['data'];
                } else {
                    $this->skippedRows[] = $rowData['error'];
                }
            }

            if (count($this->skippedRows) > 0) {
                throw new \Exception("Validation errors detected");
            }

            $this->prefetchLastItemCodes($validRows);
            
            foreach ($validRows as $rowData) {
                $this->createProduct($rowData);
                $this->importedCount++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Only add generic error if no specific row errors
            if (count($this->skippedRows) === 0) {
                $this->skippedRows[] = [
                    'row' => 'All Rows',
                    'reason' => $e->getMessage()
                ];
            }
            throw $e;
        }
    }

    private function processRow($row, $rowNumber): array
    {
        try {
            // Normalization and validation
            $normalizedRow = $this->normalizeRow($row);
            $this->validateRow($normalizedRow, $rowNumber);
            
            // Prepare data
            $companyId = $this->getReferenceId(Company::class, 'company_name', $normalizedRow['company']);
            $isSystemGenerated = $this->getSystemGeneratedSetting($companyId);
            
            $data = [
                'company_id' => $companyId,
                'supplier_id' => $this->getReferenceId(LibSupplier::class, 'supplier_name', $normalizedRow['supplier']),
                'item_category_id' => $this->getReferenceId(LibCategory::class, 'category_name', $normalizedRow['item_category']),
                'item_sub_category_id' => $this->getReferenceId(LibItemSubCategory::class, 'sub_category_name', $normalizedRow['item_sub_category']),
                'brand_id' => $this->getReferenceId(LibBrand::class, 'brand_name', $normalizedRow['brand']),
                'generic_id' => $this->getReferenceId(LibGeneric::class, 'generic_name', $normalizedRow['generic']),
                'size_id' => $this->getReferenceId(LibSize::class, 'size_name', $normalizedRow['size']),
                'color_id' => $this->getReferenceId(LibColor::class, 'color_name', $normalizedRow['color'] ?? ''),
                'item_description' => $normalizedRow['item_description'],
                'product_name_details' => $normalizedRow['product_name_details'] ?? $normalizedRow['item_description'],
                'dosage_form' => $normalizedRow['dosage_form'],
                'order_uom' => $this->getReferenceId(LibUom::class, 'uom_name', $normalizedRow['order_uom']),
                'consuption_uom' => $this->getReferenceId(LibUom::class, 'uom_name', $normalizedRow['consuption_uom']),
                'conversion_fac' => $normalizedRow['conversion_fac'],
                'is_system_generated' => $isSystemGenerated,
                // Add other fields as needed
            ];

            // Check for duplicates
            $this->checkForDuplicates($data, $rowNumber);

            return ['valid' => true, 'data' => $data];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'error' => [
                    'row' => $rowNumber,
                    'reason' => $e->getMessage()
                ]
            ];
        }
    }

    private function normalizeRow($row): array
    {
        $normalized = [];
        foreach ($row as $key => $value) {
            $cleanKey = strtolower(trim(str_replace('*', '', $key));
            $normalized[$cleanKey] = $value;
        }
        return $normalized;
    }

    private function validateRow(array $row, int $rowNumber): void
    {
        $validator = Validator::make($row, [
            'company' => 'required|string',
            'supplier' => 'required|string',
            'item_category' => 'required|string',
            'item_description' => 'required|string',
            'order_uom' => 'required|string',
            'consuption_uom' => 'required|string',
            'conversion_fac' => 'required|numeric|min:0',
            'item_sub_category' => 'required|string',
            'brand' => 'required|string',
            'size' => 'required|string',
            'dosage_form' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception(implode(', ', $validator->errors()->all()));
        }
    }

    private function getReferenceId(string $model, string $column, string $value): int
    {
        if (empty($value)) return 0;
        
        $cacheKey = $model . '|' . $value;
        if (isset($this->referenceCache[$cacheKey])) {
            return $this->referenceCache[$cacheKey];
        }

        $instance = $model::firstOrCreate(
            [$column => $value],
            ['created_by' => Auth::id()]
        );

        $this->referenceCache[$cacheKey] = $instance->id;
        return $instance->id;
    }

    private function getSystemGeneratedSetting(int $companyId): bool
    {
        return (bool) VariableSetting::where('company_id', $companyId)
            ->where('variable_id', 1)
            ->value('variable_value');
    }

    private function checkForDuplicates(array $data, int $rowNumber): void
    {
        $exists = ProductDetailsMaster::where([
            'company_id' => $data['company_id'],
            'supplier_id' => $data['supplier_id'],
            'item_category_id' => $data['item_category_id'],
            'item_sub_category_id' => $data['item_sub_category_id'],
            'brand_id' => $data['brand_id'],
            'generic_id' => $data['generic_id'],
            'size_id' => $data['size_id'],
            'item_description' => $data['item_description'],
            'dosage_form' => $data['dosage_form'],
        ])->exists();

        if ($exists) {
            throw new \Exception('Duplicate product entry');
        }
    }

    private function prefetchLastItemCodes(array $rows): void
    {
        $prefixMap = [];
        
        foreach ($rows as $row) {
            if (!$row['is_system_generated']) continue;
            
            $prefix = $this->getPrefixForRow($row);
            $prefixMap[$prefix] = true;
        }

        foreach (array_keys($prefixMap) as $prefix) {
            $lastItem = ProductDetailsMaster::where('item_code', 'like', $prefix . '%')
                ->where('is_system_generated_item_code', 1)
                ->orderBy('item_code', 'desc')
                ->first();

            $this->lastItemCodes[$prefix] = $lastItem 
                ? (int) substr($lastItem->item_code, strlen($prefix)) 
                : 0;
        }
    }

    private function getPrefixForRow(array $row): string
    {
        $cacheKey = implode('-', [
            $row['company_id'],
            $row['item_category_id'],
            $row['item_sub_category_id'],
            $row['brand_id'],
            $row['dosage_form']
        ]);
        
        if (isset($this->prefixCache[$cacheKey])) {
            return $this->prefixCache[$cacheKey];
        }

        $companyShort = strtoupper(substr(
            Company::find($row['company_id'])->company_short_name, 0, 3
        ));
        
        $categoryShort = strtoupper(substr(
            LibCategory::find($row['item_category_id'])->short_name, 0, 3
        ));
        
        $subCategoryShort = strtoupper(substr(
            LibItemSubCategory::find($row['item_sub_category_id'])->sub_category_name, 0, 3
        ));
        
        $brandShort = strtoupper(substr(
            LibBrand::find($row['brand_id'])->brand_name, 0, 3
        ));
        
        $dosageShort = strtoupper(substr($row['dosage_form'], 0, 3));

        $prefix = "{$companyShort}-{$categoryShort}-{$subCategoryShort}-{$brandShort}-{$dosageShort}";
        $this->prefixCache[$cacheKey] = $prefix;
        return $prefix;
    }

    private function createProduct(array $rowData): void
    {
        $product = new ProductDetailsMaster();
        
        // System-generated item code
        if ($rowData['is_system_generated']) {
            $prefix = $this->getPrefixForRow($rowData);
            $this->lastItemCodes[$prefix]++;
            $product->item_code = $prefix . str_pad($this->lastItemCodes[$prefix], 5, '0', STR_PAD_LEFT);
            $product->is_system_generated_item_code = 1;
        }
        
        // Map data to product attributes
        foreach ($rowData as $key => $value) {
            if ($key !== 'is_system_generated') {
                $product->$key = $value;
            }
        }
        
        $product->save();
    }
}