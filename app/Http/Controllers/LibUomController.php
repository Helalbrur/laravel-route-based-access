<?php

namespace App\Http\Controllers;

use App\Models\LibUom;
use App\Models\InvTransaction;
use App\Models\WorkOrderDtls;
use App\Models\RequisitionDtls;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LibUomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.general.uom');
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
        try{
            $lib_uom=LibUom::create([
                'uom_name'=>$request->input('txt_uom_name'),
                'created_by'=>Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_uom
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
    public function show(LibUom $libUom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibUom $libUom)
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
            $uom = LibUom::findOrFail($id);
            $user_id = Auth::user()->id;
            $uom->update([
                'uom_name'=>$request->input('txt_uom_name'),
                'updated_by'=> $user_id 
            ]);
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$uom
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
    public function destroy( $id)
    {
        DB::beginTransaction();
        try {
            $uom = LibUom::findOrFail($id);
            if (InvTransaction::where('order_uom', $uom->id)->orWhere('cons_uom', $uom->id)->exists()) {
                throw new Exception('UOM found in transactions; delete not allowed');
            }

            if (WorkOrderDtls::where('uom', $uom->id)->exists()) {
                throw new Exception('UOM found in Work Orders; delete not allowed');
            }

            if (RequisitionDtls::where('uom', $uom->id)->exists()) {
                throw new Exception('UOM found in Requisitions; delete not allowed');
            }

            $uom->delete();
            DB::commit();

            return response()->json([
                'code'    => 2,
                'message' => 'success',
                'data'    => []
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $error_message = "Error: " . $e->getMessage();

            return response()->json([
                'code'    => 10,
                'message' => $error_message,
                'data'    => []
            ], 422); // Optional: Return appropriate HTTP code
        }
    }
}
