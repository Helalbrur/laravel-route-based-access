<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Group;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menu_id = $request->query('mid') ?? 0;
        $permission = getPagePermission($menu_id);
        return view('lib.group',compact('permission'));
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
        // dd($request->input('txt_group_name'));
        DB::beginTransaction();
        try
        {
            $lib_group=Group::create([
                'group_name'=>$request->input('txt_group_name'),
                'group_short_name'=>$request->input('txt_group_short'),
                'website'=>$request->input('txt_website'),
                'address'=>$request->input('txt_address'),
                'email'=>$request->input('txt_email'),
                'created_by'=>Auth::user()->id,
                'contact_no'=>$request->input('txt_contact_no'),
                'contact_person'=>$request->input('txt_contact_person'),
                'country_id'=>$request->input('cbo_country_id'),
            ]);
    
            // Handle the uploaded files
            if ($request->hasFile('files'))
            {
                $files = $request->file('files');
                foreach ($files as $file) 
                {
                    ImageUpload::fileUploads($file,$lib_group->id,'group_profile');
                }
            }

            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$lib_group
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> [
                    'group_name'=>$request->input('txt_group_name'),
                    'group_short_name'=>$request->input('txt_group_short'),
                    'website'=>$request->input('cbo_module_sts'),
                    'address'=>$request->input('txt_address'),
                    'email'=>$request->input('txt_email'),
                    'created_by'=>Auth::user()->id,
                    'contact_no'=>$request->input('txt_contact_no'),
                    'contact_person'=>$request->input('txt_contact_person'),
                    'country_id'=>$request->input('cbo_country_id'),
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return $group;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //dd($group);
        DB::beginTransaction();
        try
        {
            $group->update([
                'group_name'=>$request->input('txt_group_name'),
                'group_short_name'=>$request->input('txt_group_short'),
                'website'=>$request->input('txt_website'),
                'address'=>$request->input('txt_address'),
                'email'=>$request->input('txt_email'),
                'updated_by'=>Auth::user()->id,
                'contact_no'=>$request->input('txt_contact_no'),
                'contact_person'=>$request->input('txt_contact_person'),
                'country_id'=>$request->input('cbo_country_id')
            ]);
    
            // Handle the uploaded files
            if ($request->hasFile('files'))
            {
                $files = $request->file('files');
                foreach ($files as $file) 
                {
                    ImageUpload::fileUploads($file,$group->id,'group_profile');
                }
            }

            DB::commit();
            //$module = MainModule::where('id',$request->update_id)->first();
            return response()->json([
                'code'=>1,
                'message'=>'success',
                'data'=>$group
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> $request->all()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        DB::beginTransaction();
        try
        {
            $ret = ImageUpload::removeFiles($group->id,'group_profile');
            $group->delete();
            DB::commit();
            return response()->json([
                'code'=>2,
                'message'=>'success',
                'data'=>$group,
                'ret'=>$ret
            ]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code'=>10,
                'message'=>$e->getMessage(),
                'data'=> $group
            ]);
        }
    }
    public function show_group_list_view(Request $request)
    {
        return view('ajax.show_module_list_view');
    }
}
