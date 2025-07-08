<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\LibItemSubGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLibItemSubGroupRequest;
use App\Http\Requests\UpdateLibItemSubGroupRequest;

class LibItemSubGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.item_details.item_sub_group');
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
            $item_group=LibItemSubGroup::create([
                'item_category_id'=>$request->input('cbo_category_id'),
                'item_group_id'=>$request->input('cbo_item_group_id'),
                'sub_group_name'=>$request->input('txt_item_sub_group_name'),
                'sub_group_code'=>$request->input('txt_item_sum_group_code'),
                'created_by'=>Auth::user()->id
            ]);
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$item_group
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
    public function show(LibItemSubGroup $libItemSubGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibItemSubGroup $libItemSubGroup)
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
            $sub_group = LibItemSubGroup::findOrFail($id);
            $sub_group->update([
                'item_category_id'=>$request->input('cbo_category_id'),
                'item_group_id'=>$request->input('cbo_item_group_id'),
                'sub_group_name'=>$request->input('txt_item_sub_group_name'),
                'sub_group_code'=>$request->input('txt_item_sum_group_code'),
                'updated_by'=>Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$sub_group
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
    public function destroy($id )
    {
        DB::beginTransaction();
        try
        {
            $sub_group = LibItemSubGroup::findOrFail($id);
            $sub_group->delete();
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
