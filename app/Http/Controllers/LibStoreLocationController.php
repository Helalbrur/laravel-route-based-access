<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\LibStoreLocation;
use Illuminate\Support\Facades\DB;
use App\Models\LibStoreTagCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLibStoreLocationRequest;
use App\Http\Requests\UpdateLibStoreLocationRequest;

class LibStoreLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.general.store');
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
            $lib_store_location=LibStoreLocation::create([
                'store_name'=>$request->input('txt_store_name'),
                'company_id'=>$request->input('cbo_company_name'),
                'store_location'=>$request->input('txt_store_name'),
                'item_category_id'=>$request->input('cbo_category_id'),
                'location_id'=>$request->input('cbo_location_name'),
                'created_by'=>Auth::user()->id
            ]);
            
            if(!empty($request->input('cbo_category_id')))
            {
                $tag_category = explode(",",$request->input('cbo_category_id'));
                foreach($tag_category as $category)
                {
                    LibStoreTagCategory::create([
                        'category_id' => $category,
                        'store_id'   => $lib_store_location->id
                    ]);
                }
            }

           

            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_store_location
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
    public function show(LibStoreLocation $libStoreLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibStoreLocation $libStoreLocation)
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
            $store = LibStoreLocation::findOrFail($id);
            $store->update([
                'store_name'=>$request->input('txt_store_name'),
                'company_id'=>$request->input('cbo_company_name'),
                'store_location'=>$request->input('txt_store_name'),
                'item_category_id'=>$request->input('cbo_category_id'),
                'location_id'=>$request->input('cbo_location_name'),
                'updated_by'=>Auth::user()->id
            ]);

            if(!empty($request->input('cbo_category_id')))
            {
                $tag_category = explode(",",$request->input('cbo_category_id'));
                //$supplier->tagCompany;
                foreach($store->tagCategory as $tag)
                {
                    $tag->delete();
                }
                foreach($tag_category as $category_id)
                {
                    LibStoreTagCategory::create([
                        'category_id' => $category_id,
                        'store_id'   => $store->id
                    ]);
                }
            }
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$store
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
    public function destroy( $id)
    {
        DB::beginTransaction();
        try
        {
            $store = LibStoreLocation::findOrFail($id);
            foreach($store->tagCategory as $tag)
            {
                $tag->delete();
            }
            $store->delete();
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
