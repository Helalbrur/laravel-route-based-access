<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductRoomRackSelf;
use App\Models\ProductDetailsMaster;

class ProductRoomRackSelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productRoomRackSelf = ProductRoomRackSelf::all();
        return view('lib.inventory.product_room_rack_self',compact('productRoomRackSelf'));
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
        $request->validate([
            'cbo_product_id' => 'required',
            'cbo_floor_name'    => 'required',  
            // 'cbo_room_no'    => 'required',  
            // 'cbo_rack_no'    => 'required',
            // 'cbo_shelf_no'   => 'required',
            // 'cbo_bin_no'     => 'required',
        ]);

        DB::beginTransaction();

        try {
            $productRoomRackSelf = ProductRoomRackSelf::create([
                'product_id' => $request->input('cbo_product_id'),
                'floor_id'    => $request->input('cbo_floor_name'),
                'room_id'    => $request->input('cbo_room_no'),
                'rack_id'    => $request->input('cbo_rack_no'),
                'shelf_id'   => $request->input('cbo_shelf_no'),
                'bin_id'     => $request->input('cbo_bin_no'),
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'code' => 0, // 0 = success (based on your save_update_delete logic)
                'message' => 'Product Room Rack Self Created Successfully',
                'data' => [
                    'id' => $productRoomRackSelf->id,
                ],
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'code' => 10,
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(ProductRoomRackSelf $productRoomRackSelf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductRoomRackSelf $productRoomRackSelf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cbo_product_id' => 'required',
            'cbo_floor_name' => 'required',
            // 'cbo_room_no' => 'required',
            // 'cbo_rack_no' => 'required',
            // 'cbo_shelf_no' => 'required',
            // 'cbo_bin_no' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $productRoomRackSelf = ProductRoomRackSelf::findOrFail($id);
            $productRoomRackSelf->update([
                'product_id'=>$request->input('cbo_product_id'),
                'floor_id'=> $request->input('cbo_floor_name'),
                'room_id'=>$request->input('cbo_room_no'),
                'rack_id'=>$request->input('cbo_rack_no'),
                'shelf_id'=>$request->input('cbo_shelf_no'),
                'bin_id'=>$request->input('cbo_bin_no'),
                'updated_by'=>auth()->user()->id,
            ]);
            DB::commit();
            return response()->json([
                'code' => 1, // 0 = success (based on your save_update_delete logic)
                'message' => 'Product Room Rack Self Updated Successfully',
                'data' => [
                    'id' => $productRoomRackSelf->id,
                ],
            ], 200);

        }
        catch(Exception $e)
        {
            DB::rollBack();

            return response()->json([
                'code' => 10,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $productRoomRackSelf = ProductRoomRackSelf::findOrFail($id);
            $productRoomRackSelf->delete();
            DB::commit();
            return response()->json([
                'code' => 2, // 0 = success (based on your save_update_delete logic)
                'message' => 'Product Room Rack Self Deleted Successfully',
                'data' => [
                    'id' => $productRoomRackSelf->id,
                ],
            ], 200);

        }
        catch(Exception $e)
        {
           DB::rollBack();

            return response()->json([
                'code' => 10,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function load_details($id)
    {
        $details = ProductRoomRackSelf::find($id);
        if ($details) {
            return response()->json([
                'id' => $details->id,
                'product_id' => $details->product_id,
                'room_id' => $details->room_id,
                'floor_id' => $details->floor_id,
                'rack_id' => $details->rack_id,
                'shelf_id' => $details->shelf_id,
                'bin_id' => $details->bin_id
            ]);
        } else {
            return response()->json(['message' => 'Details not found'], 404);
        }
    }
}
