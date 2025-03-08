<?php

namespace App\Http\Controllers;

use Exception;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try
        {
            Excel::import(new UsersImport, $request->file('file'));
            DB::commit();
            return back()->with('success', 'Users imported successfully.');
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        } 
    }
}
