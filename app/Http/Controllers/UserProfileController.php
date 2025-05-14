<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tools.user_profile');
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
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $request['name'] = $request->txt_name;
        $request['email'] = $request->txt_email;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id]
            'email' => ['required','string','email','max:255',Rule::unique(User::class)->ignore($user->id)->whereNull('deleted_at')],
        ]);
        DB::beginTransaction();
        try
        {
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->txt_phone_no,
                'type'=>$request->cbo_user_type,
            ]);

            // Handle the uploaded files
            if ($request->hasFile('files'))
            {
                $files = $request->file('files');
                ImageUpload::fileUploads($files,$user->id,'user_profile');
            }

            if(!empty($request->txt_password))
            {
                $user->update([
                    'password'=>Hash::make($request->txt_password)
                ]);
            }
            DB::commit();
            return response()->json([
                'code' => 1,
                'message' => 'Data Updated Successfully',
                'data'=>$user
            ],200);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'code' => 10,
                'message' => $e->getMessage(),
                'data'=>$user
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        //
    }
}
