<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LibLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLibLocationRequest;
use App\Http\Requests\UpdateLibLocationRequest;

class LibLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.location');
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
            $lib_location=LibLocation::create([
                'location_name'=>$request->input('txt_location_name'),
                'company_id'=>$request->input('cbo_company_name'),
                'country_id'=>$request->input('cbo_country_name'),
                'contact_person'=>$request->input('txt_contact_person'),
                'contact_no'=>$request->input('txt_contact_no'),
                'website'=>$request->input('txt_website_name'),
                'email'=>$request->input('txt_email'),
                'address'=>$request->input('txt_company_address'),
                'created_by'=>Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_location
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
    public function show(LibLocation $libLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibLocation $libLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LibLocation $location)
    {
        DB::beginTransaction();
        try
        {
            $location->update([
                'location_name'=>$request->input('txt_location_name'),
                'company_id'=>$request->input('cbo_company_name'),
                'country_id'=>$request->input('cbo_country_name'),
                'contact_person'=>$request->input('txt_contact_person'),
                'contact_no'=>$request->input('txt_contact_no'),
                'website'=>$request->input('txt_website_name'),
                'email'=>$request->input('txt_email'),
                'address'=>$request->input('txt_company_address'),
                'updated_by'=>Auth::user()->id
            ]);
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$location
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
    public function destroy(LibLocation $location)
    {
        DB::beginTransaction();
        try
        {
            $location->delete();
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
