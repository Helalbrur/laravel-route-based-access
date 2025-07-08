<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LibFloorRoomRackMst;
use App\Models\LibFloorRoomRackDtls;
use Illuminate\Support\Facades\Auth;

class LibRackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.inventory.rack');
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
            $rack = LibFloorRoomRackMst::create([
                'floor_room_rack_name' => $request->input('txt_rack_no'),
                'company_id' => $request->input('cbo_company_name'),
                'created_by' => Auth::user()->id
            ]);

            $rack_dtls = LibFloorRoomRackDtls::create([
                'company_id' => $request->input('cbo_company_name'),
                'location_id' => $request->input('cbo_location_name'),
                'store_id' => $request->input('cbo_store_name'),
                'floor_id' => $request->input('cbo_floor_name'),
                'room_id' => $request->input('cbo_room_no'),
                'rack_id' => $rack->id,
                'created_by' => Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'success',
                'data' => [
                    'id' => $rack->id,
                    'company_id' => $rack->company_id,
                    'location_id' => $rack_dtls->location_id,
                    'store_id' => $rack_dtls->store_id,
                    'floor_id' => $rack_dtls->floor_id,
                    'room_id' => $rack_dtls->room_id,
                    'rack_id' => $rack->id,
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
            $rack = LibFloorRoomRackMst::findOrFail($id);
            $rack->update([
                'floor_room_rack_name' => $request->input('txt_rack_no'),
                'company_id' => $request->input('cbo_company_name'),
                'updated_by' => Auth::user()->id
            ]);

            $rack_dtls = $rack->rack_details;
            if ($rack_dtls) {
                $rack_dtls->update([
                    'company_id' => $request->input('cbo_company_name'),
                    'location_id' => $request->input('cbo_location_name'),
                    'store_id' => $request->input('cbo_store_name'),
                    'floor_id' => $request->input('cbo_floor_name'),
                    'room_id' => $request->input('cbo_room_no'),
                    'updated_by' => Auth::user()->id
                ]);
            }

            DB::commit();

            return response()->json([
                'code' => 1,
                'message' => 'success',
                'data' => [
                    'id' => $rack->id,
                    'company_id' => $rack->company_id,
                    'location_id' => $rack_dtls->location_id,
                    'store_id' => $rack_dtls->store_id,
                    'floor_id' => $rack_dtls->floor_id,
                    'room_id' => $rack_dtls->room_id,
                    'rack_id' => $rack->id,
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
            $rack = LibFloorRoomRackMst::findOrFail($id);
            $rack->rack_details()->delete();
            $rack->delete();

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
        $rack = LibFloorRoomRackMst::with(['rack_details'])
            ->where('id', $id)
            // ->whereNull('deleted_at') // Handles soft delete
            ->first();

        if (!$rack) {
            return response()->json(['message' => 'Rack not found'], 404);
        }

        return response()->json([
            'id' => $rack->id,
            'company_id' => $rack->company_id,
            'location_id' => $rack->rack_details->location_id ?? null,
            'store_id' => $rack->rack_details->store_id ?? null,
            'floor_id' => $rack->rack_details->floor_id ?? null,
            'room_id' => $rack->rack_details->room_id ?? null,
            'rack_no' => $rack->floor_room_rack_name,
            'rack_id' => $rack->id,
            'created_by' => $rack->created_by
        ]);
    }
}
