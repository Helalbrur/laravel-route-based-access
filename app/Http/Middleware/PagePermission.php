<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\MainMenu;
use App\Models\UserPrivMst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PagePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $allowed = false;
        $permissions = [];

        if ($user)
        {
            $segments = array_slice(explode('/', $request->path()), 0, -1);
            $urlPath = implode('/', $segments);
            $mainMenu = MainMenu::where(function($query) use ($urlPath,$request) {
                $query->where('f_location', $request->path())
                    ->orWhere('f_location', '=', $urlPath);
            })->first();

            if ($mainMenu)
            {
                $userPrivMst = UserPrivMst::where('user_id', $user->id)
                    ->where('main_menu_id', $mainMenu->m_menu_id)
                    ->first();
                if ($userPrivMst)
                {
                    $url_parts = explode('/', $request->path());
                    $id = end($url_parts);

                    switch ($request->method())
                    {
                        case 'GET':
                            if ($userPrivMst->show_priv) {
                                $permissions[] = 'show';
                            }
                            break;
                        case 'POST':
                            if ($userPrivMst->save_priv == 1) {
                                $permissions[] = 'save';
                            }
                            break;
                        case 'PATCH':
                        case 'PUT':
                            if ($userPrivMst->edit_priv == 1  && is_numeric($id)) {
                                $permissions[] = 'edit';
                            }
                            break;
                        case 'DELETE':
                            // // Check for the presence of the ID parameter in the URL
                            if ($userPrivMst->delete_priv == 1 && is_numeric($id)) {
                                $permissions[] = 'delete';
                            }
                            break;
                    }

                    if (!empty($permissions)) {
                        $allowed = true;
                        $request->merge(['permissions' => $permissions]);
                    }
                }
            }
        }

        if (!$allowed) {
            //abort(403, 'Unauthorized access');
            if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized access'], 403);
            }
            else
            {
                return response()->view('errors.403', [], 403);
            }
        }

        return $next($request);
    }

}
