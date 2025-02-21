<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LibFloorRoomRackMst;
use App\Models\LibFloorRoomRackDtls;
use Illuminate\Support\Facades\Auth;

class LibRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.inventory.room');
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
            $lib_room=LibFloorRoomRackMst::create([
                'floor_room_rack_name'=>$request->input('txt_room_no'),
                'company_id'=>$request->input('cbo_company_name'),
                'created_by'=>Auth::user()->id
            ]);

            $lib_room_dtls=LibFloorRoomRackDtls::create([
                'company_id'=>$request->input('cbo_company_name'),
                'location_id'=>$request->input('cbo_location_name'),
                'store_id'=>$request->input('cbo_store_name'),
                'floor_id'=>$request->input('cbo_floor_name'),
                'room_id'=>$lib_room->id,
                'created_by'=>Auth::user()->id
            ]);
            
            DB::commit();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>[
                    'id'=>$lib_room->id,
                    'company_id'=>$lib_room->company_id,
                    'location_id'=>$lib_room_dtls->location_id,
                    'store_id'=>$lib_room_dtls->store_id,
                    'floor_id'=>$lib_room_dtls->floor_id,
                    'room_no'=>$lib_room->floor_room_rack_name,
                    'room_id'=>$lib_room->id,
                    'created_by'=>Auth::user()->id
                ]
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function load_details($id)
    {
        $room = LibFloorRoomRackMst::with(['room_details'])
        ->where('id', $id)
        ->whereNull('deleted_at') // Handles soft delete
        ->first();

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        return response()->json([
            'id' => $room->id,
            'company_id' => $room->company_id,
            'location_id' => $room->room_details->location_id ?? null,
            'store_id' => $room->room_details->store_id ?? null,
            'floor_id' => $room->room_details->floor_id ?? null,
            'room_no' => $room->floor_room_rack_name,
            'room_id' => $room->id,
            'created_by' => $room->created_by
        ]);

    }
}
