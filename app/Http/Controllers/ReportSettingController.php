<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Exception;

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
        DB::beginTransaction();
        try
        {
            $setting=ReportSetting::create([
                'company_id' => $request->cbo_company_name,
                'module_id' => $request->cbo_module_name,
                'report_id' => $request->cbo_report_name,
                'format_id'=> $request->cbo_format_name,
                'user_id' => $request->cbo_user_id,
                'created_by' => Auth::user()->id
            ]);
            DB::commit();
            return response()->json(
                $setting
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
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
        $setting->update([
            'company_id' => $request->cbo_company_name,
            'module_id' => $request->cbo_module_name,
            'report_id' => $request->cbo_report_name,
            'format_id'=> $request->cbo_format_name,
            'user_id' => $request->cbo_user_id,
            'updated_by' => Auth::user()->id
        ]);
        DB::commit();
        return response()->json(
            $setting
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,ReportSetting $setting)
    {
        DB::beginTransaction();
        try
        {
            $setting->delete();
            DB::commit();
            return response()->json(
                ['status' => 'ok', 'message' => 'Delete Success'], 200
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }
}
