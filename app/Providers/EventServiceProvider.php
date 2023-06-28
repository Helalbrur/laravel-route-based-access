<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;

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
        
        if (config('app.log_queries')) {
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $table_name = $this->extractTableNameFromQuery($sql);
                if($this->isInsertOrUpdateQuery($sql) && !$this->isLogsQuery($sql))
                {
                    $createdBy = Auth::check() ? Auth::user()->id : null;
                     // Replace the placeholders in the SQL statement with actual values from bindings
                    foreach ($bindings as $binding) {
                        $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
                        $sql = preg_replace('/\?/', $value, $sql, 1);
                    }
                    //$bindingsData = json_encode($bindings);
                    \App\Models\Log::create([
                        'query' => $sql, 
                        'table_name' => $table_name ?? '',
                        'created_by' => $createdBy,
                    ]);
                }
        
            });
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
        $matches = [];
        preg_match('/(?:FROM|from|INSERT INTO|insert into|UPDATE|update) `(.+?)`/i', $sql, $matches);
        return $matches[1] ?? null;
    }

        
    private function extractTableName($queryType, $sql, $bindings)
    {
        $tableName = '';
    
        if ($queryType === 'DELETE') {
            preg_match('/from `(.+?)`/i', $sql, $matches);
            if (isset($matches[1])) {
                $tableName = $matches[1];
            }
        } else {
            if (!empty($bindings)) {
                $firstBinding = $bindings[0];
    
                if (is_string($firstBinding)) {
                    preg_match('/from `(.+?)`/i', $firstBinding, $matches);
    
                    if (isset($matches[1])) {
                        $tableName = $matches[1];
                    }
                }
            }
        }
    
        return $tableName;
    }

    private function isInsertQuery($sql)
    {
        $lowerSql = trim(strtolower($sql));
        return str_contains($lowerSql, 'insert into');
    }

    private function isUpdateQuery($sql)
    {
        $lowerSql = trim(strtolower($sql));
        return str_contains($lowerSql, 'update set');
    }

    private function isDeleteQuery($sql)
    {
        $lowerSql = trim(strtolower($sql));
        return str_contains($lowerSql, 'delete from');
    }


    private function isLogsQuery($sql)
    {
        $lowerSql = strtolower($sql);
        return str_contains($lowerSql, 'log_table');
    }


    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
