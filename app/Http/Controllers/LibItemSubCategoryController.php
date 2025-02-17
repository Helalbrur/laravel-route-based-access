<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\LibItemSubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LibItemSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.item_details.item_sub_category');
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
            $sub_category=LibItemSubCategory::create([
                'item_category_id'=>$request->input('cbo_category_id'),
                'sub_category_name'=>$request->input('txt_item_sub_category_name'),
                'created_by'=>Auth::user()->id
            ]);
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$sub_category
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LibItemSubCategory $sub_category)
    {
        DB::beginTransaction();
        try
        {
            $sub_category->update([
                'item_category_id'=>$request->input('cbo_category_id'),
                'sub_category_name'=>$request->input('txt_item_sub_category_name'),
                'updated_by'=>Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$sub_category
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
    public function destroy(LibItemSubCategory $sub_category)
    {
        dd($sub_category);
        DB::beginTransaction();
        try
        {
            $sub_category->delete();
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
