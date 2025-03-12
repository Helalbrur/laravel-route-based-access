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
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class ProductImport implements ToCollection, WithHeadingRow
{
    public $importedCount = 0;
    public $skippedRows = [];
    
    public function collection(Collection $rows)
    {
        DB::beginTransaction(); // Start transaction

        try {
            $insertData = [];
            $rowNumber = 1;

            foreach ($rows as $row) {
                $rowNumber++;

                // Validate row
                $validator = Validator::make($row->toArray(), [
                    'company'           => 'required|string',
                    'supplier'          => 'required|string',
                    'item_category'     => 'required|string',
                    'item_group'        => 'required|string',
                    'item_description'  => 'required|string',
                    'uom'               => 'required|string',
                    'order_uom'         => 'required|string',
                    'consuption_uom'    => 'required|string',
                    'conversion_fac'    => 'required|numeric|min:0',
                ]);

                if ($validator->fails()) {
                    $this->skippedRows[] = [
                        'row'       => $rowNumber,
                        'reason'    => $validator->errors()->all()
                    ];
                    throw new \Exception("Validation failed at row {$rowNumber}: " . implode(', ', $validator->errors()->all()));
                }

                // Get IDs of referenced models
                $company_id        = optional(Company::where('company_name', $row['company'])->first())->id;
                $supplier_id       = $this->getOrCreateModel(LibSupplier::class, 'supplier_name', $row['supplier'])->id ?? null;
                $item_category_id  = $this->getOrCreateModel(LibCategory::class, 'category_name', $row['item_category'])->id ?? null;
                $item_group_id     = $this->getOrCreateModel(LibItemGroup::class, 'item_name', $row['item_group'])->id ?? null;
                $uom_id            = $this->getOrCreateModel(LibUom::class, 'uom_name', $row['consuption_uom'])->id ?? null;

                // Check for duplicates
                $existingProduct = ProductDetailsMaster::where([
                    'company_id'       => $company_id,
                    'supplier_id'      => $supplier_id,
                    'item_category_id' => $item_category_id,
                    'item_group_id'    => $item_group_id,
                    'item_description' => $row['item_description'],
                    'consuption_uom'   => $uom_id
                ])->exists();

                if ($existingProduct) {
                    $this->skippedRows[] = [
                        'row'       => $rowNumber,
                        'reason'    => ['Duplicate entry']
                    ];
                    throw new \Exception("Duplicate entry found at row {$rowNumber}");
                }

                // Prepare data for bulk insertion
                $insertData[] = [
                    'company_id'       => $company_id,
                    'supplier_id'      => $supplier_id,
                    'item_category_id' => $item_category_id,
                    'item_group_id'    => $item_group_id,
                    'item_description' => $row['item_description'] ?? '',
                    'consuption_uom'   => $uom_id,
                    'created_by'       => Auth::id(),
                    'updated_by'       => Auth::id(),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }

            // If there are no skipped rows, insert all data at once
            if (!empty($insertData)) {
                ProductDetailsMaster::insert($insertData);
                $this->importedCount = count($insertData);
            }

            DB::commit(); // Commit transaction

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error
            throw $e; // Throw exception to be handled in the controller
        }
    }

    private function getOrCreateModel($model, $column, $value)
    {
        if (empty($value)) {
            return null;
        }

        return $model::firstOrCreate(
            [$column => $value],
            ['created_by' => Auth::id()]
        );
    }
}
