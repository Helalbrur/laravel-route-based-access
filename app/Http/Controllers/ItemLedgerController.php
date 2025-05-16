<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DynamicHtmlExport;
use App\Exports\HtmlToExcelExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Symfony\Component\HttpFoundation\StreamedResponse;
class ItemLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = $this->getFilteredData($request);
        return view('reports.item_ledger', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $transactions = $this->getFilteredData($request);
    
        //dd($transactions);
        return view('reports.item_ledger_report_content', compact('transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function excelExport_backup(Request $request)
    {
        $htmlContent = $request->html;
        return Excel::download(
            new HtmlToExcelExport($htmlContent), 
            'item-ledger.xlsx'
        );
        /*
        $htmlContent = view('reports.excel.item_ledger_content', [
            'htmlContent' => $request->html
        ])->render();

        return Excel::download(
            new HtmlToExcelExport($htmlContent), 
            'item-ledger.xlsx'
        );
        */

        //return Excel::download(new DynamicHtmlExport($request->html), 'item-ledger.xlsx');
    }

    public function excelExport(Request $request)
    {

        $html = $request->html;
        // Format dates for Excel compatibility
        $html = preg_replace_callback('/(\d{1,2}-\d{1,2}-\d{4})/', function ($matches) {
            return '<span class="excel-date">' . $matches[1] . '</span>';
        }, $html);

        // Load HTML into PhpSpreadsheet
        $reader = IOFactory::createReader('Html');

        if (method_exists($reader, 'loadFromString')) {
            $spreadsheet = $reader->loadFromString($html);
        } else {
            $tempFile = tmpfile();
            fwrite($tempFile, $html);
            $meta = stream_get_meta_data($tempFile);
            $spreadsheet = $reader->load($meta['uri']);
            fclose($tempFile);
        }

        $worksheet = $spreadsheet->getActiveSheet();

        // Auto-adjust and limit column widths
        foreach ($worksheet->getColumnIterator() as $column) {
            $colIndex = $column->getColumnIndex();
            $maxLength = 0;

            foreach ($worksheet->getRowIterator() as $row) {
                $cell = $worksheet->getCell($colIndex . $row->getRowIndex());
                $value = $cell->getValue();
                if ($value !== null) {
                    $length = strlen((string) $value);
                    $maxLength = max($maxLength, $length);
                }
            }

            $width = min($maxLength + 2, 20); // padding + max width
            $worksheet->getColumnDimension($colIndex)
                ->setWidth($width)
                ->setAutoSize(false);

            $worksheet->getStyle($colIndex . '1:' . $colIndex . $worksheet->getHighestRow())
                ->getAlignment()
                ->setWrapText(false)
                ->setShrinkToFit(false);
        }

        // Add zero-width space to adjacent empty cells to prevent content clipping
        $highestRow = $worksheet->getHighestRow();
        $highestCol = $worksheet->getHighestColumn();

        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 'A'; $col <= $highestCol; $col++) {
                $cell = $worksheet->getCell($col . $row);
                if ($cell->getValue() !== null) {
                    // Right cell
                    $nextCol = chr(ord($col) + 1);
                    if ($nextCol <= 'Z' && !$worksheet->getCell($nextCol . $row)->getValue()) {
                        $worksheet->getCell($nextCol . $row)->setValue("\u{200B}");
                        $worksheet->getStyle($nextCol . $row)->getFont()->setColor(
                            new Color(Color::COLOR_WHITE)
                        );
                    }

                    // Left cell
                    if ($col > 'A') {
                        $prevCol = chr(ord($col) - 1);
                        if (!$worksheet->getCell($prevCol . $row)->getValue()) {
                            $worksheet->getCell($prevCol . $row)->setValue("\u{200B}");
                            $worksheet->getStyle($prevCol . $row)->getFont()->setColor(
                                new Color(Color::COLOR_WHITE)
                            );
                        }
                    }
                }
            }
        }

        $fileName = 'item-ledger_' . now()->format('Ymd_His') . '.xlsx';

        // Return as download (no file saved)
        return new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }


    private function getFilteredData($request)
    {
        $query = DB::table('inv_transaction as a')
            ->select(
                'a.id as transaction_id',
                'a.product_id',
                'e.item_description',
                'e.consuption_uom as uom',
                'a.cons_qnty as cons_qnty',
                'a.cons_rate as cons_rate',
                'a.cons_amount as cons_amount',
                'a.store_id',
                DB::raw("CASE 
                    WHEN a.transaction_type IN (1, 4, 5) THEN 'Receipt' 
                    ELSE 'Issue' END as transaction_type"),
                DB::raw("CASE 
                    WHEN a.transaction_type IN (1, 4) THEN b.receive_date 
                    WHEN a.transaction_type IN (2, 3) THEN c.date 
                    ELSE d.transfer_date END as transaction_date"),
                DB::raw("CASE 
                    WHEN a.transaction_type IN (1, 4) THEN b.sys_number 
                    WHEN a.transaction_type IN (2, 3) THEN c.sys_number 
                    ELSE d.transfer_no END as sys_number"),
                DB::raw("CASE 
                    WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_qnty 
                    ELSE -a.cons_qnty END as quantity"),
                'a.cons_rate as rate',
                DB::raw("CASE 
                    WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_amount 
                    ELSE -a.cons_amount END as amount"),
                DB::raw('SUM(
                    CASE 
                        WHEN a.transaction_type IN (1, 4, 5) THEN a.cons_qnty 
                        ELSE -a.cons_qnty 
                    END) OVER (
                        PARTITION BY a.product_id 
                        ORDER BY a.id 
                        ROWS BETWEEN CURRENT ROW AND UNBOUNDED FOLLOWING
                    ) as balance')
            )
            ->leftJoin('inv_receive_master as b', function($join) {
                $join->on('a.mst_id', '=', 'b.id')
                    ->whereIn('a.transaction_type', [1, 4]);
            })
            ->leftJoin('inv_issue_master as c', function($join) {
                $join->on('a.mst_id', '=', 'c.id')
                    ->whereIn('a.transaction_type', [2, 3]);
            })
            ->leftJoin('transfer_mst as d', function($join) {
                $join->on('a.mst_id', '=', 'd.id')
                    ->whereIn('a.transaction_type', [5, 6]);
            })
            ->join('product_details_master as e', 'a.product_id', '=', 'e.id')
            ->whereIn('a.transaction_type', [1, 2, 3, 4, 5, 6])
            ->whereNull('a.deleted_at');

        // Date Range Filter
        if (!empty($request->txt_date_from) && !empty($request->txt_date_to)) {
            $from = date('Y-m-d', strtotime($request->txt_date_from));
            $to = date('Y-m-d', strtotime($request->txt_date_to));
            
            $query->whereRaw("
                CASE 
                    WHEN a.transaction_type IN (1,4) THEN b.receive_date 
                    WHEN a.transaction_type IN (2,3) THEN c.date 
                    WHEN a.transaction_type IN (5,6) THEN d.transfer_date 
                END BETWEEN ? AND ?
            ", [$from, $to]);
        }

        // Product Filters
        if (!empty($request->hidden_product_id)) {
            $query->where('a.product_id', $request->hidden_product_id);
        } elseif (!empty($request->txt_product_name)) {
            $query->where('e.item_description', 'LIKE', "%{$request->txt_product_name}%");
        }

        // Additional Filters
        $query->when(!empty($request->txt_item_code), function($q) use ($request) {
                $q->where('e.item_code', $request->txt_item_code);
            })
            ->when(!empty($request->txt_origin), function($q) use ($request) {
                $q->where('e.item_origin', $request->txt_origin);
            })
            ->when(!empty($request->cbo_generic_name), function($q) use ($request) {
                $q->where('e.generic_id', $request->cbo_generic_name);
            })
            ->when(!empty($request->cbo_item_category), function($q) use ($request) {
                $q->where('e.item_category_id', $request->cbo_item_category);
            })
            ->when(!empty($request->cbo_company_name), function($q) use ($request) {
                $q->where('e.company_id', $request->cbo_company_name);
            });

        
        
        $query->orderBy('a.id');
        // Order by transaction date
        $query->orderByRaw("
            CASE 
                WHEN a.transaction_type IN (1,4) THEN b.receive_date 
                WHEN a.transaction_type IN (2,3) THEN c.date 
                ELSE d.transfer_date 
            END
        ");

        return $query->get();
    }

}
