<?php

namespace App\Http\Controllers;

use App\Models\LibFloorRoomRackMst;
use App\Http\Requests\StoreLibFloorRoomRackMstRequest;
use App\Http\Requests\UpdateLibFloorRoomRackMstRequest;
use App\Models\MainMenu;
use Illuminate\Http\Request;

class LibFloorRoomRackMstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menu_id = $request->query('mid') ?? 0;
        $menu = MainMenu::where('m_menu_id',$menu_id)->first();
        return view(implode(".",explode("/",$menu->f_location)));
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
    public function store(StoreLibFloorRoomRackMstRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LibFloorRoomRackMst $libFloorRoomRackMst)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibFloorRoomRackMst $libFloorRoomRackMst)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibFloorRoomRackMstRequest $request, LibFloorRoomRackMst $libFloorRoomRackMst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LibFloorRoomRackMst $libFloorRoomRackMst)
    {
        //
    }
}
