<?php

namespace App\Http\Controllers;

use App\Models\ReportSetting;
use Illuminate\Http\Request;

class ReportSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.variable_setting.report_setting');
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
    public function show(ReportSetting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportSetting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportSetting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportSetting $setting)
    {
        //
    }
}
