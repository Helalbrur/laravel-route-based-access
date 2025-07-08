<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Client\Request as ClientRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.company');
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
            $lib_company=Company::create([
                'group_id'=>$request->input('cbo_group_name'),
                'company_name'=>$request->input('txt_company_name'),
                'company_short_name'=>$request->input('txt_company_short_name'),
                'website'=>$request->input('txt_website_name'),
                'address'=>$request->input('txt_company_address'),
                'email'=>$request->input('txt_email'),
                'created_by'=>Auth::user()->id,
                'contact_no'=>$request->input('txt_contact_no')
            ]);
    
            // Handle the uploaded files
            if ($request->hasFile('files'))
            {
                $files = $request->file('files');
                ImageUpload::fileUploads($files,$lib_company->id,'company_profile');
            }

            DB::commit();
            Cache::forget("company_name");
            $company = Company::orderBy('id','desc')->first();
            $company_name = $company->company_name ?? '';
            Cache::put("company_name", $company_name,now()->addDay());
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_company
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> [
                    'group_id'=>$request->input('cbo_group_name'),
                    'company_name'=>$request->input('txt_company_name'),
                    'company_short_name'=>$request->input('txt_company_short_name'),
                    'website'=>$request->input('txt_website_name'),
                    'address'=>$request->input('txt_company_address'),
                    'email'=>$request->input('txt_email'),
                    'created_by'=>Auth::user()->id,
                    'contact_no'=>$request->input('txt_contact_no')
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return $company;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        DB::beginTransaction();
        try
        {
            $company = Company::findOrFail($id);
            
            $company->update([
                'group_id'=>$request->input('cbo_group_name'),
                'company_name'=>$request->input('txt_company_name'),
                'company_short_name'=>$request->input('txt_company_short_name'),
                'website'=>$request->input('txt_website_name'),
                'address'=>$request->input('txt_company_address'),
                'email'=>$request->input('txt_email'),
                'created_by'=>Auth::user()->id,
                'contact_no'=>$request->input('txt_contact_no')
            ]);
    
            // Handle the uploaded files
            if ($request->hasFile('files'))
            {
                $files = $request->file('files');
                ImageUpload::fileUploads($files,$company->id,'company_profile');
            }

            DB::commit();
            Cache::forget("company_name");
            $company = Company::orderBy('id','desc')->first();
            $company_name = $company->company_name ?? '';
            Cache::put("company_name", $company_name,now()->addDay());
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$company
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> $request->all()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        DB::beginTransaction();
        try
        {
            $company = Company::findOrFail($id);
            $ret = ImageUpload::removeFiles($company->id,'company_profile');
            $company->delete();
            DB::commit();
            Cache::forget("company_name");
            $company = Company::orderBy('id','desc')->first();
            $company_name = $company->company_name ?? '';
            Cache::put("company_name", $company_name,now()->addDay());
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>$company,
                'ret'=>$ret
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> $company
            ]);
        }
    }
}
