<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;

class HtmlToExcelExport implements FromView, WithStyles
{
    protected $htmlContent;

    public function __construct($htmlContent)
    {
        $this->htmlContent = $htmlContent;
    }

    public function view(): View
    {
        return view('reports.excel.html_to_excel', [
            'htmlContent' => $this->htmlContent
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Apply cell merging based on HTML structure
        $dom = new \DOMDocument();
        @$dom->loadHTML($this->htmlContent);
        $table = $dom->getElementsByTagName('table')->item(0);

        $rowIndex = 1;
        foreach ($table->getElementsByTagName('tr') as $tr) {
            $colIndex = 0;
            foreach ($tr->getElementsByTagName('td') as $td) {
                $rowspan = (int) $td->getAttribute('rowspan') ?: 1;
                $colspan = (int) $td->getAttribute('colspan') ?: 1;

                if ($rowspan > 1 || $colspan > 1) {
                    $sheet->mergeCells(
                        $this->getCellRange($rowIndex, $colIndex, $rowspan, $colspan)
                    );
                }

                $colIndex += $colspan;
            }
            $rowIndex++;
        }

        return [
            1 => ['font' => ['bold' => true]],
            'A:M' => [
                'alignment' => ['wrapText' => true],
                'numberFormat' => ['formatCode' => '#,##0.00']
            ],
            'E:M' => [
                'numberFormat' => ['formatCode' => '#,##0.0000']
            ]
        ];
    }

    private function getCellRange($row, $col, $rowspan, $colspan)
    {
        $start = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . $row;
        $endCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + $colspan) . ($row + $rowspan - 1);
        return "{$start}:{$endCol}";
    }
}