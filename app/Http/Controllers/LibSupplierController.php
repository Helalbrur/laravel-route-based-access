<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LibSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    public function update(Request $request, LibSupplier $supplier)
    {
        DB::beginTransaction();
        try
        {
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
            $supplier->delete();
            foreach($supplier->tagCompany() as $tag)
            {
                $tag->delete();
            }
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
}
