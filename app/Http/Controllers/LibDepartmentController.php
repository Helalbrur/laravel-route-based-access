<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\LibDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLibDepartmentRequest;
use App\Http\Requests\UpdateLibDepartmentRequest;

class LibDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lib.general.department');
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
            $lib_department = LibDepartment::create([
                'department_name' => $request->input('txt_department_name'),
                'company_id' => $request->input('cbo_company_id') ?? null,
                'created_by' => Auth::user()->id
            ]);

            DB::commit();
            return response()->json([
                'code' => 0,
                'message' => 'success',
                'data' => $lib_department
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $error_message = "Error: " . $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine();
            return response()->json([
                'code' => 10,
                'message' => $error_message,
                'data' => []
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LibDepartment $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LibDepartment $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LibDepartment $department)
    {
        DB::beginTransaction();
        try
        {
            $department->update([
                'department_name'=>$request->input('txt_department_name'),
                'company_id' => $request->input('cbo_company_id') ?? null,
                'updated_by'=>Auth::user()->id
            ]);
    
            DB::commit();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$department
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
     * Remove the specified resource from storage.
     */
    public function destroy(LibDepartment $department)
    {
        DB::beginTransaction();
        try
        {
            $department->delete();

            DB::commit();
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>[]
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
}
