<?php

namespace App\Http\Controllers;

use App\Models\LibLocation;
use App\Http\Requests\StoreLibLocationRequest;
use App\Http\Requests\UpdateLibLocationRequest;

class LibLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.location');
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
    public function store(StoreLibLocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LibLocation $libLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibLocation $libLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibLocationRequest $request, LibLocation $libLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LibLocation $libLocation)
    {
        //
    }
}
