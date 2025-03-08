<?php

namespace App\Providers;

use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        $yes_no = array(1 => "Yes", 2 => "No");
        DB::listen(function ($query) {

            if(!empty($query->sql))
            {
                //echo $query->sql;
                //Log::create(['user_id'=>Auth::user()->id ?? 0,'query'=>$query->sql]);
            }


            // $query->bindings
            // $query->time
        });
        DB::whenQueryingForLongerThan(500, function (Connection $connection, QueryExecuted $event) {
            // Notify development team...
            //Log::create(['user_id'=>Auth::user()->id ?? 0,'query'=>$query->sql]);
        });
    }
}
