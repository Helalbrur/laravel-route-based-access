<?php

namespace App\Http\Controllers;

use App\Models\UserPrivMst;
use App\Http\Requests\StoreUserPrivMstRequest;
use App\Http\Requests\UpdateUserPrivMstRequest;
use Illuminate\Http\Request;

class UserPrivMstController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = getPagePermission();
        return view('tools.user_previledge',compact('permission'));
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
    public function store(StoreUserPrivMstRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPrivMst $userPrivMst)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPrivMst $userPrivMst)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPrivMstRequest $request, UserPrivMst $userPrivMst)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPrivMst $userPrivMst)
    {
        //
    }
    public function load_priviledge_list(Request $request)
    {
        $data = $request->query('data') ?? 0;
        return view('tools.load_priviledge_list',compact('data'));
    }
}
