<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManualBackupCommand extends Command
{
    protected $signature = 'backup:manual';
    
    protected $description = 'Perform a manual backup';

    public function handle()
    {
        try
        {
            $backupDirectory = storage_path('app/backups');

            // Get the current timestamp to generate a unique backup file name
            $timestamp = now()->format('Ymd_His');
            $backupFilename = 'backup_' . $timestamp . '.sql';

            // Backup the database using mysqldump command
            $databaseName = config('database.connections.mysql.database');
            $databaseUser = config('database.connections.mysql.username');
            $databasePassword = config('database.connections.mysql.password');
            $command = sprintf(
                'mysqldump -u %s -p%s %s > %s/%s',
                $databaseUser,
                $databasePassword,
                $databaseName,
                $backupDirectory,
                $backupFilename
            );
            exec($command);

            // Optionally, you can include additional files or directories in the backup
            // For example, you can use the Storage facade to copy files to the backup directory
            // Storage::disk('local')->copy('file.txt', $backupDirectory . '/file.txt');

            $this->info('Backup created successfully: ' . $backupFilename);
        }
        catch(Exception $e)
        {
            $this->info($e->getMessage());
        }
        
    }
}
