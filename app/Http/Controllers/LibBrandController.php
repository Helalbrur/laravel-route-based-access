<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\LibBrand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLibBrandRequest;
use App\Http\Requests\UpdateLibBrandRequest;

class LibBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.general.brand');
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
        try {
            $lib_brand = LibBrand::create([
                'name' => $request->input('txt_brand_name'),
                'buyer_id' => $request->input('cbo_buyer_id'),
                'created_by' => Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'success',
                'data' => $lib_brand
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $error_message = "Error: " . $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine();
            return response()->json([
                'code' => 10,
                'message' => $error_message,
                'data' => []
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LibBrand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibBrand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LibBrand $brand)
    {
        DB::beginTransaction();
        try
        {
            $brand->update([
                'name'=>$request->input('txt_brand_name'),
                'buyer_id'=>$request->input('cbo_buyer_id'),
                'updated_by'=>Auth::user()->id
            ]);
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$brand
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
     * Remove the specified resource from storage.
     */
    public function destroy(LibBrand $brand)
    {
        DB::beginTransaction();
        try
        {
            $brand->delete();

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
