<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = getPermissionBasedAllRoutes();
        $users = User::get();
        return view('admin.permission',compact('routes','users'));
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
        //if(Auth::user()->role =='user') return redirect()->back()->with('error','Only Admin have access this route');
        DB::enableQueryLog();

        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        $users = User::whereIn('id',$request->input('user_id'))->get();

        //dd(DB::getQueryLog());


        // // code to execute first transaction
        while (DB::transactionLevel() > 1) {
            sleep(1); // wait for the running transaction to complete
        }
        DB::beginTransaction();
        // // code to execute second transaction
        try
        {

            foreach($users as $user)
            {
                $permissions_arr = $request->input('permissions_'.$user->id);
                $permissionIdArr=[];
                foreach($user->permissions as $prev_permission)
                {
                    if($prev_permission->id == 1 || $prev_permission->id == 2) $permissionIdArr[$prev_permission->id]=$prev_permission->id;
                }
                foreach($user->permissions as $prev_permission)
                {
                    $prev_permission->userPermission()->delete();
                }
                foreach($permissions_arr as $perm)
                {
                    $route_name = $request->input('route_name_'.$user->id.'_'.str_replace(" ","_",$perm));
                    //echo "<pre> route_name = ".$route_name."</pre>";
                    $permission = Permission::where('name',$perm)->where('route_name',$route_name)->first();
                    if(empty($permission->id) && !empty($route_name))
                    {
                        $permission = Permission::create(['name' => $perm , 'route_name'=>$route_name]);
                    }
                    if(!empty($permission->id))
                    {
                        $permissionIdArr[$permission->id]=$permission->id;
                    }
                }
                if(count($permissionIdArr))
                {
                    $user->permissions()->sync($permissionIdArr);
                    // echo "<pre>";
                    // print_r(DB::getQueryLog());
                    // echo "</pre>";
                }

            }
            DB::commit();
            return redirect()->back()->with('success', 'Permission Given successfully');
        }
        catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }

    public function popup(Request $request)
    {
        $data['user_id'] = $request->user_id;
        $data['about'] = $request->about;
        return view('admin.popup',compact('data'));
    }
}
