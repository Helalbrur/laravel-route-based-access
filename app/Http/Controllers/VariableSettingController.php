<?php

namespace App\Http\Controllers;

use App\Models\VariableSetting;
use Illuminate\Http\Request;

class VariableSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //pass only company_id,varaiable_id,variable_value,id not all fields or model use DB::select

        return view('lib.variable_setting.setting');
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
        $this->validate($request, [
            'cbo_company_name' => 'required',
            'cbo_variable_name' => 'required'
        ]);
        if($request->cbo_variable_name == 1 || $request->cbo_variable_name == 2)
        {
            $this->validate($request, [
                'cbo_variable_value' => 'required'
            ]);

            if(VariableSetting::where('company_id', $request->cbo_company_name)->where('variable_id', $request->cbo_variable_name)->exists())
            {
               $setting = VariableSetting::where('company_id', $request->cbo_company_name)
                                            ->where('variable_id', $request->cbo_variable_name)
                                            ->update(['variable_value' => $request->cbo_variable_value]);
            }
            else
            {
                $setting =  VariableSetting::create([
                    'company_id' => $request->cbo_company_name,
                    'variable_id' => $request->cbo_variable_name,
                    'variable_value' => $request->cbo_variable_value
                ]);
            }
        }
        else if($request->cbo_variable_name == 3)
        {
            $this->validate($request, [
                'cbo_variable_value' => 'required|numeric'
            ]);
            if(VariableSetting::where('company_id', $request->cbo_company_name)->where('variable_id', $request->cbo_variable_name)->exists())
            {
               $setting = VariableSetting::where('company_id', $request->cbo_company_name)
                                            ->where('variable_id', $request->cbo_variable_name)
                                            ->where('over_receive', $request->txt_over_receive)
                                            ->update(['variable_value' => $request->cbo_variable_value]);
            }
            else
            {
                $setting =  VariableSetting::create([
                    'company_id' => $request->cbo_company_name,
                    'variable_id' => $request->cbo_variable_name,
                    'variable_value' => $request->cbo_variable_value,
                    'over_receive' => $request->txt_over_receive
                ]);
            }
        }
        else
        {
            $this->validate($request, [
                'cbo_variable_value' => 'required|numeric'
            ]);
            $setting = [];
        }

        
        return response()->json([
            'code' => 0,
            'message' => 'Record Updated Successfully',
            'data'=>$setting
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(VariableSetting $variableSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VariableSetting $variableSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VariableSetting $setting)
    {
        $this->validate($request, [
            'cbo_company_name' => 'required',
            'cbo_variable_name' => 'required'
        ]);
        if($request->cbo_variable_name == 1 || $request->cbo_variable_name == 2)
        {
            $this->validate($request, [
                'cbo_variable_value' => 'required'
            ]);
            $setting = $setting->update(['variable_value' => $request->cbo_variable_value]);
        }
        else
        {
            $this->validate($request, [
                'cbo_variable_value' => 'required|numeric'
            ]);
            $setting = [];
        }

        
        return response()->json([
            'code' => 0,
            'message' => 'Record Updated Successfully',
            'data'=>$setting
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariableSetting $variableSetting)
    {
        //
    }
}
