<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LibFloorRoomRackMst;
use App\Models\LibFloorRoomRackDtls;
use Illuminate\Support\Facades\Auth;

class LibShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.inventory.shelf');
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
            $shelf = LibFloorRoomRackMst::create([
                'floor_room_rack_name' => $request->input('txt_shelf_no'),
                'company_id' => $request->input('cbo_company_name'),
                'created_by' => Auth::user()->id
            ]);

            $shelf_dtls = LibFloorRoomRackDtls::create([
                'company_id' => $request->input('cbo_company_name'),
                'location_id' => $request->input('cbo_location_name'),
                'store_id' => $request->input('cbo_store_name'),
                'floor_id' => $request->input('cbo_floor_name'),
                'room_id' => $request->input('cbo_room_no'),
                'rack_id' => $request->input('cbo_rack_no'),
                'shelf_id' => $shelf->id,
                'created_by' => Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'success',
                'data' => [
                    'id' => $shelf->id,
                    'company_id' => $shelf->company_id,
                    'location_id' => $shelf_dtls->location_id,
                    'store_id' => $shelf_dtls->store_id,
                    'floor_id' => $shelf_dtls->floor_id,
                    'room_id' => $shelf_dtls->room_id,
                    'rack_id' => $shelf_dtls->rack_id,
                    'shelf_id' => $shelf->id,
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
    public function update(Request $request, LibFloorRoomRackMst $shelf)
    {

        DB::beginTransaction();
        try {
            $shelf->update([
                'floor_room_rack_name' => $request->input('txt_shelf_no'),
                'company_id' => $request->input('cbo_company_name'),
                'updated_by' => Auth::user()->id
            ]);

            $shelf_dtls = $shelf->shelf_details;
            if ($shelf_dtls) {
                $shelf_dtls->update([
                    'company_id' => $request->input('cbo_company_name'),
                    'location_id' => $request->input('cbo_location_name'),
                    'store_id' => $request->input('cbo_store_name'),
                    'floor_id' => $request->input('cbo_floor_name'),
                    'room_id' => $request->input('cbo_room_no'),
                    'rack_id' => $request->input('cbo_rack_no'),
                    'updated_by' => Auth::user()->id
                ]);
            }

            DB::commit();

            return response()->json([
                'code' => 1,
                'message' => 'success',
                'data' => [
                    'id' => $shelf->id,
                    'company_id' => $shelf->company_id,
                    'location_id' => $shelf_dtls->location_id,
                    'store_id' => $shelf_dtls->store_id,
                    'floor_id' => $shelf_dtls->floor_id,
                    'room_id' => $shelf_dtls->room_id,
                    'rack_id' => $shelf_dtls->rack_id,
                    'shelf_id' => $shelf->id,
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
    public function destroy(LibFloorRoomRackMst $shelf)
    {
        DB::beginTransaction();
        try {

            $shelf->shelf_details()->delete();
            $shelf->delete();

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
        $shelf = LibFloorRoomRackMst::with(['shelf_details'])
            ->where('id', $id)
            // ->whereNull('deleted_at') // Handles soft delete
            ->first();

        if (!$shelf) {
            return response()->json(['message' => 'Shelf not found'], 404);
        }

        return response()->json([
            'id' => $shelf->id,
            'company_id' => $shelf->company_id,
            'location_id' => $shelf->shelf_details->location_id ?? null,
            'store_id' => $shelf->shelf_details->store_id ?? null,
            'floor_id' => $shelf->shelf_details->floor_id ?? null,
            'room_id' => $shelf->shelf_details->room_id ?? null,
            'rack_id' => $shelf->shelf_details->rack_id ?? null,
            'shelf_no' => $shelf->floor_room_rack_name,
            'shelf_id' => $shelf->id,
            'created_by' => $shelf->created_by
        ]);
    }
}
