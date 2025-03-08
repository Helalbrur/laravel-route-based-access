<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class DynamicHtmlExport implements FromView, ShouldAutoSize
{
    protected $htmlContent;

    public function __construct($htmlContent)
    {
        $this->htmlContent = $htmlContent;
    }

    public function view(): View
    {
        // Convert the HTML content into a view and pass it to the export
        return view('exports.dynamic_html_export', ['htmlContent' => $this->htmlContent]);
    }
}
