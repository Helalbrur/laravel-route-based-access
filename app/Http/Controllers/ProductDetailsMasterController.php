<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProductDetailsMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductDetailsMasterRequest;
use App\Http\Requests\UpdateProductDetailsMasterRequest;

class ProductDetailsMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.general.product_details_master');
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
            $lib_location=ProductDetailsMaster::create([
                'company_id'=>$request->input('cbo_company_name'),
                'supplier_id'=>$request->input('cbo_supplier_name'),
                'generic_id'=>$request->input('cbo_generic_name'),
                'item_category_id'=>$request->input('cbo_item_category_name'),
                'item_sub_category_id'=>$request->input('cbo_sub_category_name'),
                'item_type'=>$request->input('txt_item_type'),
                'item_description'=>$request->input('txt_item_name'),
                'item_code'=>$request->input('txt_item_code'),
                'item_origin'=>$request->input('txt_item_origin'),
                'brand_id'=>$request->input('cbo_brand_name'),
                'dosage_form'=>$request->input('txt_dosage_form'),
                'color_id'=>$request->input('cbo_color_name'),
                'order_uom'=>$request->input('cbo_order_uom'),
                'order_uom_qty'=>$request->input('txt_order_uom_qty'),
                'consuption_uom'=>$request->input('txt_consuption_uom_qty'),
                'consuption_uom_qty'=>$request->input('txt_consuption_uom_qty'),
                'conversion_fac'=>$request->input('txt_conversion_fac'),
                'size_id'=>$request->input('cbo_size_name'),
                'power'=>$request->input('txt_power'),
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
    public function show(Request $request, ProductDetailsMaster $lib_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ProductDetailsMaster $lib_item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       if(empty($id))
       {
           return response()->json([
               'code'=>10,
               'message'=>'Update Id not found',
               'data'=>[]
           ],500);
       }
       $item=ProductDetailsMaster::find($id);
       if(empty($item))
       {
           return response()->json([
               'code'=>10,
               'message'=>'Item not found',
               'data'=>[]
           ],500);
       }
        DB::beginTransaction();
        try
        {
            $item->update([
                'company_id'=>$request->input('cbo_company_name'),
                'supplier_id'=>$request->input('cbo_supplier_name'),
                'generic_id'=>$request->input('cbo_generic_name'),
                'item_category_id'=>$request->input('cbo_item_category_name'),
                'item_sub_category_id'=>$request->input('cbo_sub_category_name'),
                'item_type'=>$request->input('txt_item_type'),
                'item_description'=>$request->input('txt_item_name'),
                'item_code'=>$request->input('txt_item_code'),
                'item_origin'=>$request->input('txt_item_origin'),
                'brand_id'=>$request->input('cbo_brand_name'),
                'dosage_form'=>$request->input('txt_dosage_form'),
                'color_id'=>$request->input('cbo_color_name'),
                'order_uom'=>$request->input('cbo_order_uom'),
                'order_uom_qty'=>$request->input('txt_order_uom_qty'),
                'consuption_uom'=>$request->input('txt_consuption_uom_qty'),
                'consuption_uom_qty'=>$request->input('txt_consuption_uom_qty'),
                'conversion_fac'=>$request->input('txt_conversion_fac'),
                'size_id'=>$request->input('cbo_size_name'),
                'power'=>$request->input('txt_power'),
                'updated_by'=>Auth::user()->id
            ]);
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$item
            ],200);
        }
        catch(Exception $e)
        {
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item=ProductDetailsMaster::find($id);
        DB::beginTransaction();
        try
        {
            $item->delete();
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
