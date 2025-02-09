<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class UserImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel',
        ]);
        
        $extension = $request->file('file')->getClientOriginalExtension();
        if (!in_array($extension, ['csv', 'xlsx'])) {
            return back()->withErrors(['file' => 'Invalid file format. Please upload a CSV or Excel file.']);
        }

        try
        {
            Excel::import(new UsersImport, $request->file('file'));
            return back()->with('success', 'Users imported successfully.');
        }
        catch(Exception $e)
        {
            return back()->with('success', $e->getMessage());
        } 
    }
}
