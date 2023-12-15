<?php

namespace App\Providers;

use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
        
        if (env('LOG_QUERIES', '')) {
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $table_name = $this->extractTableNameFromQuery($sql);
                if($this->isNotLogsQuery($sql) && $this->isInsertOrUpdateQuery($sql))
                {
                    $this->deleteLog();
                    $createdBy = Auth::check() ? Auth::user()->id : null;
                     // Replace the placeholders in the SQL statement with actual values from bindings
                    foreach ($bindings as $binding) {
                        $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
                        $sql = preg_replace('/\?/', $value, $sql, 1);
                    }
                    //$bindingsData = json_encode($bindings);
                    Log::create([
                        'query' => $sql, 
                        'table_name' => $table_name ?? '',
                        'created_by' => $createdBy,
                    ]);
                }
        
            });
        }         
    }

    private function deleteLog()
    {
        if (Log::count() > 500) {
            $oldestLogs = Log::orderBy('id','DESC')->take(Log::count() - 500)->get();
            foreach ($oldestLogs as $log) {
                $log->delete();
            }
        }
    }
    private function isInsertOrUpdateQuery($sql)
    {
        $lowerSql = strtolower($sql);
        return (
            strpos($lowerSql, 'insert into') !== false ||
            (strpos($lowerSql, 'update') !== false && strpos($lowerSql, 'set') !== false) ||
            strpos($lowerSql, 'delete from') !== false
        );
    }
    
    private function extractTableNameFromQuery($sql)
    {
        $sql = strtolower($sql);
        $matches = [];
        preg_match('/(?:from|insert into|update|delete from) `(.+?)`/i', $sql, $matches);
        return $matches[1] ?? null;
    }

    private function isNotLogsQuery($sql)
    {
        $lowerSql = strtolower($sql);
        return str_contains($lowerSql, 'log_table') == false;
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
