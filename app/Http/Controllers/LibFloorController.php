<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\LibFloor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LibFloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.inventory.floor');
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
            $lib_floor=LibFloor::create([
                'floor_name'=>$request->input('txt_floor_name'),
                'company_id'=>$request->input('cbo_company_name'),
                'store_id'=>$request->input('cbo_store_name'),
                'seq'=>$request->input('txt_floor_seq'),
                'location_id'=>$request->input('cbo_location_name'),
                'created_by'=>Auth::user()->id
            ]);
            
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_floor
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
    public function show(LibFloor $libFloor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibFloor $libFloor)
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
            $floor = LibFloor::findOrFail($id);
            $floor->update([
                'floor_name'=>$request->input('txt_floor_name'),
                'company_id'=>$request->input('cbo_company_name'),
                'store_id'=>$request->input('cbo_store_name'),
                'seq'=>$request->input('txt_floor_seq'),
                'location_id'=>$request->input('cbo_location_name'),
                'updated_by'=>Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$floor
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
            $floor = LibFloor::findOrFail($id);
            $floor->delete();
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
