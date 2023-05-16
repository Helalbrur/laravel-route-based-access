<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use App\Models\MainModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = getPagePermission();
        //dd($permission);
        return view('tools.create_main_module',compact('permission'));
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
            $mModule=MainModule::orderBy('m_mod_id','DESC')->first();
            $m_mod_id=1;
            if(!empty($mModule->m_mod_id))
            {
                $m_mod_id=$mModule->m_mod_id + 1;
            }
            else if(!empty($mModule->id))
            {
                $m_mod_id=$mModule->id + 1;
            }
            $mainModule=MainModule::create([
                'main_module'=>$request->txt_module_name,
                'file_name'=>$request->txt_module_link,
                'status'=>$request->cbo_module_sts,
                'mod_slno'=>$request->txt_module_seq,
                'm_mod_id'=>$m_mod_id
            ]);
            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json(
                $mainModule
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
    public function show(MainModule $mainModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MainModule $mainModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MainModule $module)
    {
        DB::beginTransaction();
        try
        {
            $mainModule = MainModule::find($request->update_id);
            $mainModule->update([
                'main_module'=>$request->txt_module_name,
                'file_name'=>$request->txt_module_link,
                'status'=>$request->cbo_module_sts,
                'mod_slno'=>$request->txt_module_seq,
                'm_mod_id'=>$request->hidden_m_mod_id,
            ]);
            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json(
                $mainModule
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    public function create_main_module_update(Request $request)
    {
        try
        {
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json(
                $request->all()
            );
        }
        catch(Exception $e)
        {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainModule $module)
    {
        DB::beginTransaction();
        try
        {
            $module->delete();
            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
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
    public function get_data_by_id($id)
    {
        try
        {
            $module = MainModule::where('m_mod_id',$id)->first();
            return response()->json(
                [
                    'm_mod_id' => $module->m_mod_id,
                    'main_module'=>$module->main_module,
                    'file_name'=>$module->file_name,
                    'status'=>$module->status,
                    'mod_slno'=>$module->mod_slno,
                    'id'=>$module->id
                ]
            );
        }
        catch(Exception $e)
        {
            return response()->json($e->getMessage());
        }
    }
    public function show_module_list_view()
    {
        return view('tools.show_module_list_view');
    }
}
