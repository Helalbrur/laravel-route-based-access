<?php

namespace App\Http\Controllers;

use App\Models\LibBuyer;
use App\Http\Requests\StoreLibBuyerRequest;
use App\Http\Requests\UpdateLibBuyerRequest;

class LibBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.buyer');
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
    public function store(StoreLibBuyerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LibBuyer $libBuyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibBuyer $libBuyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibBuyerRequest $request, LibBuyer $libBuyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LibBuyer $libBuyer)
    {
        //
    }
}
