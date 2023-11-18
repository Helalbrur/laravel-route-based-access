<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();
        
        $sql = "SELECT page_id, company_id, user_id, field_id, field_name, is_disable, default_value FROM field_level_access WHERE user_id = ?";
        $sql_exe = DB::select($sql, [$user->id]);

        foreach ($sql_exe as $row) {
            Session::put('laravel_stater.data_arr.'.$row->page_id.'.'.$row->company_id.'.'.$row->field_name.'.is_disable', $row->is_disable);
            Session::put('laravel_stater.data_arr.'.$row->page_id.'.'.$row->company_id.'.'.$row->field_name.'.default_value', $row->default_value);
        }
        

        $sql = "SELECT id, page_id, field_id, field_name, field_message, is_mandatory FROM mandatory_field WHERE is_mandatory = 1 AND field_name IS NOT NULL";
        $sql_exe = DB::select($sql);

        foreach ($sql_exe as $row) {
            Session::put('laravel_stater.mandatory_field.'.$row->page_id.'.'.$row->field_id, $row->field_name);
            Session::put('laravel_stater.mandatory_message.'.$row->page_id.'.'.$row->field_id, $row->field_message);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Session::forget('laravel_stater');

        return redirect('/');
    }
}
