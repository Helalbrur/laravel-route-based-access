<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LibCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLibCountryRequest;
use App\Http\Requests\UpdateLibCountryRequest;

class LibCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menu_id = $request->query('mid') ?? 0;
        $permission = getPagePermission($menu_id);
        return view('lib.general.country',compact('permission'));
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
            $lib_country=LibCountry::create([
                'country_name'=>$request->input('txt_country_name')
            ]);

            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_country
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
    public function show(LibCountry $libCountry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibCountry $libCountry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LibCountry $country)
    {
        DB::beginTransaction();
        try
        {
            $country->update([
                'country_name'=>$request->input('txt_country_name')
            ]);
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$country
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
    public function destroy(LibCountry $country)
    {
        DB::beginTransaction();
        try
        {
            $country->delete();
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
