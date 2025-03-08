<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $module_id = $request->query('module_id') ?? 0;

        // Check if key exists in session => if (Session::has('module_id'))
        // Remove preivous =>Session::forget('module_id');

        //Set and Update data in session
        Session::put('module_id', $module_id);

        return view('dashboard');
    }
}
