<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\OtherCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtherCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.other_company');
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
        // Validate name requirement and store name and short_name in database
        $validatedData = $request->validate([
            'txt_name' => 'required|string|max:255'
        ]);

        
        DB::beginTransaction();
        try
        {
            $otherCompany=OtherCompany::create([
                'name'=>$request->input('txt_name'),
                'short_name'=>$request->input('txt_short_name'),
            ]);
    
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$otherCompany
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> [
                    'name'=>$request->input('txt_name'),
                    'short_name'=>$request->input('txt_short_name')
                ]
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(OtherCompany $otherCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OtherCompany $otherCompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OtherCompany $company)
    {
        $validatedData = $request->validate([
            'txt_name' => 'required|string|max:255'
        ]);
        DB::beginTransaction();
        try
        {
            $company->update([
                'name'=>$request->input('txt_name'),
                'short_name'=>$request->input('txt_short_name'),
            ]);
    
            DB::commit();
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
    public function destroy(OtherCompany $company)
    {
        DB::beginTransaction();
        try
        {
            $company->delete();
            DB::commit();
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>$company,
                'ret'=>0
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
