<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LibFloorRoomRackMst;
use App\Models\LibFloorRoomRackDtls;
use Illuminate\Support\Facades\Auth;

class LibBinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.inventory.bin');
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
            $bin = LibFloorRoomRackMst::create([
                'floor_room_rack_name' => $request->input('txt_bin_no'),
                'company_id' => $request->input('cbo_company_name'),
                'created_by' => Auth::user()->id
            ]);

            $bin_dtls = LibFloorRoomRackDtls::create([
                'company_id' => $request->input('cbo_company_name'),
                'location_id' => $request->input('cbo_location_name'),
                'store_id' => $request->input('cbo_store_name'),
                'floor_id' => $request->input('cbo_floor_name'),
                'room_id' => $request->input('cbo_room_no'),
                'rack_id' => $request->input('cbo_rack_no'),
                'shelf_id' => $request->input('cbo_shelf_no'),
                'bin_id' => $bin->id,
                'created_by' => Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'success',
                'data' => [
                    'id' => $bin->id,
                    'company_id' => $bin->company_id,
                    'location_id' => $bin_dtls->location_id,
                    'store_id' => $bin_dtls->store_id,
                    'floor_id' => $bin_dtls->floor_id,
                    'room_id' => $bin_dtls->room_id,
                    'rack_id' => $bin_dtls->rack_id,
                    'shelf_id' => $bin_dtls->shelf_id,
                    'bin_id' => $bin->id,
                    'created_by' => Auth::user()->id
                ]
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            $error_message = "Error: " . $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine();
            return response()->json([
                'code' => 10,
                'message' => $error_message,
                'data' => []
            ], 500);
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
    public function update(Request $request,  $id)
    {

        DB::beginTransaction();
        try {
            $bin = LibFloorRoomRackMst::findOrFail($id);
            $bin->update([
                'floor_room_rack_name' => $request->input('txt_bin_no'),
                'company_id' => $request->input('cbo_company_name'),
                'updated_by' => Auth::user()->id
            ]);

            $bin_dtls = $bin->bin_details;
            if ($bin_dtls) {
                $bin_dtls->update([
                    'company_id' => $request->input('cbo_company_name'),
                    'location_id' => $request->input('cbo_location_name'),
                    'store_id' => $request->input('cbo_store_name'),
                    'floor_id' => $request->input('cbo_floor_name'),
                    'room_id' => $request->input('cbo_room_no'),
                    'rack_id' => $request->input('cbo_rack_no'),
                    'shelf_id' => $request->input('cbo_shelf_no'),
                    'updated_by' => Auth::user()->id
                ]);
            }

            DB::commit();

            return response()->json([
                'code' => 1,
                'message' => 'success',
                'data' => [
                    'id' => $bin->id,
                    'company_id' => $bin->company_id,
                    'location_id' => $bin_dtls->location_id,
                    'store_id' => $bin_dtls->store_id,
                    'floor_id' => $bin_dtls->floor_id,
                    'room_id' => $bin_dtls->room_id,
                    'rack_id' => $bin_dtls->rack_id,
                    'shelf_id' => $bin_dtls->shelf_id,
                    'bin_id' => $bin->id,
                    'updated_by' => Auth::user()->id
                ]
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            $error_message = "Error: " . $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine();
            return response()->json([
                'code' => 10,
                'message' => $error_message,
                'data' => []
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        DB::beginTransaction();
        try {
            $bin = LibFloorRoomRackMst::findOrFail($id);
            $bin->bin_details()->delete();
            $bin->delete();

            DB::commit();

            return response()->json([
                'code' => 2,
                'message' => 'success',
                'data' => []
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 10,
                'message' => "Error: {$e->getMessage()} in {$e->getFile()} at line {$e->getLine()}",
                'data' => []
            ], 500);
        }
    }

    public function load_details($id)
    {
        $bin = LibFloorRoomRackMst::with(['bin_details'])
            ->where('id', $id)
            // ->whereNull('deleted_at') // Handles soft delete
            ->first();

        if (!$bin) {
            return response()->json(['message' => 'Bin not found'], 404);
        }

        return response()->json([
            'id' => $bin->id,
            'company_id' => $bin->company_id,
            'location_id' => $bin->bin_details->location_id ?? null,
            'store_id' => $bin->bin_details->store_id ?? null,
            'floor_id' => $bin->bin_details->floor_id ?? null,
            'room_id' => $bin->bin_details->room_id ?? null,
            'rack_id' => $bin->bin_details->rack_id ?? null,
            'shelf_id' => $bin->bin_details->shelf_id ?? null,
            'bin_no' => $bin->floor_room_rack_name,
            'bin_id' => $bin->id,
            'created_by' => $bin->created_by
        ]);
    }
}
