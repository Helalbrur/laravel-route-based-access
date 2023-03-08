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

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            $middleware = $route->middleware();
            //dd($middleware);
            $permission = '';

            foreach ($middleware as $m) {
                if (preg_match('/^CheckPermission:(.*)$/', $m, $matches)) {
                    $permission = $matches[1];
                    break;
                }
            }

            return [
                'permission' => $permission,
                'route_name' => $route->getName(),
                'uri' => $route->uri(),
                'method' => implode('|', $route->methods()),
            ];
        })->filter(function($route){
            return !empty($route['permission']);
        });
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
        DB::enableQueryLog();
        
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        $users = User::whereIn('id',$request->input('user_id'))->get();
       
        //dd(DB::getQueryLog());


        // // code to execute first transaction
        while (DB::transactionLevel() > 1) {
            sleep(1); // wait for the transaction to complete
        }
        DB::beginTransaction();
        // // code to execute second transaction
        try
        {

            foreach($users as $user)
            {
                $permissions_arr = $request->input('permissions_'.$user->id);
                $permissionIdArr=[];
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
                        //$user->permissions()->syncWithoutDetaching($permission->id);
                    }
                    // echo "<pre>";
                    // print_r(DB::getQueryLog());
                    // echo "</pre>";
                }
                if(count($permissionIdArr))
                {
                    $user->permissions()->sync($permissionIdArr);
                    echo "<pre>";
                    print_r(DB::getQueryLog());
                    echo "</pre>";
                }
                
            }
            DB::commit();
            //return redirect()->back()->with('success', 'Permission Given successfully');
        }
        catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            //throw $e;
            //return redirect()->back()->with('error', $e->getMessage());
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
}
