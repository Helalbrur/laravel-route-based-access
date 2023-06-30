<?php

namespace App\Http\Controllers;

use App\Models\MandatoryField;
use Illuminate\Http\Request;

class MandatoryFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.mandatory_field');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MandatoryField $mandatory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MandatoryField $mandatory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MandatoryField $mandatory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MandatoryField $mandatory)
    {
        //
    }

    public function entry_form_popup()
    {
        return view('ajax.entry_form_popup');
    }
}
