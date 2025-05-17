<?php

namespace App\Http\Controllers;

use App\Exports\LibSupplierExport;
use Exception;
use App\Models\LibSupplier;
use Illuminate\Http\Request;
use App\Imports\LibSupplierImport;
use Illuminate\Support\Facades\DB;
use App\Models\LibSupplierTagParty;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LibSupplierTagCompany;
use App\Http\Requests\StoreLibSupplierRequest;
use App\Http\Requests\UpdateLibSupplierRequest;

class LibSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.supplier');
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
        DB::beginTransaction();
        try
        {
            $lib_supplier=LibSupplier::create([
                'supplier_name'=>$request->input('txt_supplier_name'),
                'short_name'=>$request->input('txt_short_name'),
                'country_id'=>$request->input('cbo_country_name'),
                'tag_company'=>$request->input('cbo_tag_company_name'),
                'party_type'=>$request->input('cbo_tag_party_name'),
                'contact_person'=>$request->input('txt_contact_person'),
                'contact_no'=>$request->input('txt_contact_no'),
                'web_site'=>$request->input('txt_website_name'),
                'email'=>$request->input('txt_email'),
                'address'=>$request->input('txt_supplier_address'),
                'other_company_id'=>$request->input('cbo_supplier_company'),
                'created_by'=>Auth::user()->id
            ]);
            
            if(!empty($request->input('cbo_tag_company_name')))
            {
                $companies = explode(",",$request->input('cbo_tag_company_name'));
                foreach($companies as $company_id)
                {
                    LibSupplierTagCompany::create([
                        'company_id' => $company_id,
                        'supplier_id'   => $lib_supplier->id
                    ]);
                }
            }

            if(!empty($request->input('cbo_tag_party_name')))
            {
                $parties = explode(",",$request->input('cbo_tag_party_name'));
                foreach($parties as $party_type)
                {
                    LibSupplierTagParty::create([
                        'party_type' => $party_type,
                        'supplier_id'   => $lib_supplier->id
                    ]);
                }
            }

           

            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_supplier
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LibSupplier $libSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibSupplier $libSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $supplier = LibSupplier::withTrashed()->where('id','=',$id)->first();
            
            // Handle soft delete/restore based on cbo_status
            if ($request->input('cbo_status') == 1) {
                // Restore soft-deleted record
                if ($supplier->trashed()) {
                    $supplier->restore();
                }
            } else {
                // Soft delete if not already deleted
                if (!$supplier->trashed()) {
                    $supplier->delete();
                }
            }
           
            $supplier->update([
                'supplier_name'=>$request->input('txt_supplier_name'),
                'short_name'=>$request->input('txt_short_name'),
                'country_id'=>$request->input('cbo_country_name'),
                'tag_company'=>$request->input('cbo_tag_company_name'),
                'party_type'=>$request->input('cbo_tag_party_name'),
                'contact_person'=>$request->input('txt_contact_person'),
                'contact_no'=>$request->input('txt_contact_no'),
                'web_site'=>$request->input('txt_website_name'),
                'email'=>$request->input('txt_email'),
                'address'=>$request->input('txt_supplier_address'),
                'other_company_id'=>$request->input('cbo_supplier_company'),
                'updated_by'=>Auth::user()->id
            ]);

            if(!empty($request->input('cbo_tag_company_name')))
            {
                $companies = explode(",",$request->input('cbo_tag_company_name'));
                //$supplier->tagCompany;
                foreach($supplier->tagCompany as $tag)
                {
                    $tag->delete();
                }
                foreach($companies as $company_id)
                {
                    LibSupplierTagCompany::create([
                        'company_id' => $company_id,
                        'supplier_id'   => $supplier->id
                    ]);
                }
            }
            if(!empty($request->input('cbo_tag_party_name')))
            {
                foreach($supplier->tagParty as $tag)
                {
                    $tag->delete();
                }
                $parties = explode(",",$request->input('cbo_tag_party_name'));
                foreach($parties as $party_type)
                {
                    LibSupplierTagParty::create([
                        'party_type' => $party_type,
                        'supplier_id'   => $supplier->id
                    ]);
                }
            }
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$supplier
            ]);
        }
        catch(Exception $e)
        {
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LibSupplier $supplier)
    {
        DB::beginTransaction();
        try
        {
            
            foreach($supplier->tagCompany() as $tag)
            {
                $tag->delete();
            }
            foreach($supplier->tagParty as $tag)
            {
                $tag->delete();
            }
            $supplier->delete();
            DB::commit();
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>[]
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel',
        ]);
        
        $extension = $request->file('file')->getClientOriginalExtension();
        if (!in_array($extension, ['csv', 'xlsx'])) {
            return back()->withErrors(['file' => 'Invalid file format. Please upload a CSV or Excel file.']);
        }

        try {
            Excel::import(new LibSupplierImport, $request->file('file'));

            return response()->json([
                'code' => 0,
                'message' => 'Import successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 10,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function export()
    {
        return Excel::download(new LibSupplierExport, 'lib_suppliers.csv');
    }

}
