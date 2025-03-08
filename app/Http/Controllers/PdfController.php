<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class PdfController extends Controller
{
    public function generatePdf()
    {
        // Define custom font path
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        // Initialize mPDF with correct font settings
        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [public_path('fonts')]), // Ensure font directory is added
            'fontdata' => $fontData + [
                'solaimanlipi' => [
                    'R' => 'SolaimanLipi.ttf',
                    'useOTL' => true,
                    'useKashida' => true, // Not needed for Bangla
                ],
                'siyamrupali' => [
                    'R' => 'Siyamrupali.ttf',
                    'useOTL' => true,
                    'useKashida' => true,
                ],
                'kalpurush' => [
                    'R' => 'kalpurush.ttf',
                    'useOTL' => true,
                    'useKashida' => true,
                ]
            ],
            'default_font' => 'kalpurush' // Set default Bangla font
        ]);

        // Bangla Content with explicit font styles
        $html = '
            <h2 style="text-align: center; font-family: solaimanlipi;">বাংলা ভাষার পিডিএফ</h2>
            <p style="font-family: siyamrupali;">
                দীর্ঘ ১৫ মাস রক্তক্ষয়ী সংঘাতের পর গত ১৯ জানুয়ারি থেকে গাজায় যুদ্ধবিরতি শুরু হয়েছে। 
                এখন চলছে যুদ্ধবিরতি প্রথম ধাপ। এরই মধ্যে গতকাল সোমবার ইসরায়েলের বিরুদ্ধে চুক্তি লঙ্ঘনের অভিযোগ এনেছে হামাস। 
                জিম্মি মুক্তির প্রক্রিয়াও স্থগিত করেছে তারা। 
            </p>
            <p style="font-family: kalpurush;">
                এদিকে গাজা ঘিরে একের পর এক উসকানিমূলক বক্তব্য দিয়ে যাচ্ছেন যুক্তরাষ্ট্রের প্রেসিডেন্ট ডোনাল্ড ট্রাম্প। 
                সব মিলিয়ে যুদ্ধবিরতি চুক্তি কীভাবে ঝুঁকির মধ্যে পড়ছে, তা নিয়ে লিখেছেন বিবিসির কূটনৈতিক প্রতিনিধি পল অ্যাডামস।
            </p>
        ';

        $mpdf->WriteHTML($html);

        // Output the PDF
        return response()->streamDownload(function () use ($mpdf) {
            $mpdf->Output();
        }, 'bangla-pdf.pdf');
    }
}
