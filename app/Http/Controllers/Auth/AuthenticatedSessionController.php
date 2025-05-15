<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Models\FieldManager;
use Illuminate\Http\Request;
use App\Models\MandatoryField;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
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
        //dd($user);
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

        $sql = "SELECT id, entry_form, field_id, field_name, field_message, is_hide FROM field_managers WHERE is_hide = 1 AND field_name IS NOT NULL and user_id = ?";
        $sql_exe = DB::select($sql,[$user->id]);

        foreach ($sql_exe as $row) {
            Session::put('laravel_stater.field_manager.'.$row->entry_form.'.'.$row->field_id, $row->field_name);
            Session::put('laravel_stater.field_manager_message.'.$row->entry_form.'.'.$row->field_id, $row->field_message);
        }

        $this->cacheFieldManagerData($user->id);
        //dd(Auth::user());
        return redirect()->intended(route('home'));
    }

    protected function cacheFieldManagerData($userId)
    {
        Cache::forget("field_manager_{$userId}");
        Cache::forget("mandatory_field");
        $data = FieldManager::where('user_id', $userId)
            ->get()
            ->groupBy('entry_form')
            ->map(function($items) {
                return $items->where('is_hide', 1)
                            ->pluck('field_name')
                            ->toArray();
            });
        $mandatory = MandatoryField::get()
            ->groupBy('page_id')
            ->map(function($items) {
                return $items->where('is_mandatory', 1)
                            ->pluck('field_name')
                            ->toArray();
            });
        
        Cache::put("field_manager_{$userId}", $data, now()->addDay());
        Cache::put("mandatory_field", $mandatory, now()->addDay());
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
