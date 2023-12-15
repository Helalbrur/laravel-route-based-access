<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.user_management');
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
        $request['name'] = $request->txt_name;
        $request['email'] = $request->txt_email;
        $request['password'] = $request->txt_password;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Password::defaults()],
        ]);
        DB::beginTransaction();
        try
        {
            $user=User::create([
                'name'=>$request->txt_name,
                'email'=>$request->txt_email,
                'phone'=>$request->txt_phone_no,
                'type'=>$request->cbo_user_type,
                'password'=>Hash::make($request->txt_password)
            ]);
            DB::commit();
            return response()->json(
                $user
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request['name'] = $request->txt_name;
        $request['email'] = $request->txt_email;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id]
        ]);
        DB::beginTransaction();
        try
        {
            $user->update([
                'name'=>$request->txt_name,
                'email'=>$request->txt_email,
                'phone'=>$request->txt_phone_no,
                'type'=>$request->cbo_user_type
            ]);
            if(!empty($request->txt_password))
            {
                $user->update([
                    'password'=>Hash::make($request->txt_password)
                ]);
            }
            DB::commit();
            return response()->json(
                $user
            );
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
