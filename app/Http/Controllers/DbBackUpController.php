<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class DbBackUpController extends Controller
{
    public function index()
    {
        
        return view('DbBackup.index');
    }

    public function store(Request $request)
    {
        try
        {
            // Path to the backup directory
            //$backupDirectory = storage_path('app/backups'); //uses of storage/app/backup
            //$backupDirectory = app_path('database/seeders'); //uses of app/database/seeders
            $backupDirectory = base_path('database/seeders'); // uses of projectfolder/databse/seeders

            // Create the directory if it doesn't exist
            if (!file_exists($backupDirectory)) {
                mkdir($backupDirectory, 0755, true);
            }

            // Use glob to get a list of all .sql files in the directory
           
            $sqlFiles = glob($backupDirectory . '/backup.sql');

            // Rename all .sql file
            foreach ($sqlFiles as $sqlFile)
            {
                // Get the original name of the file without the extension
                $originalName = pathinfo($sqlFile, PATHINFO_FILENAME);
                // Get the current date, month, and year in the format d_m_Y
                $date = date('d_m_Y').'-r-'. rand(1,100) ;
                // Form the new name by concatenating the original name, the underscore, and the date
                $newName = $backupDirectory . '/backup-' .$date . '.sql';
                // Rename the file using the rename function
                rename($sqlFile, $newName);
            }
            
           

            // Define a filename for the backup
            $fileName = 'backup.sql';
            $backupPath = $backupDirectory . '/' . $fileName;

            // Construct the command to perform the database backup
            $command = env('MYSQLDUMP_PATH') . ' --user='.env('DB_USERNAME').' --skip-password --host=localhost '.env('DB_DATABASE');

            $descriptors = [
                0 => ['pipe', 'r'], // stdin
                1 => ['file', $backupPath, 'w'], // stdout
                2 => ['file', storage_path('logs/dump_error.log'), 'a'], // stderr
            ];

            $process = proc_open($command, $descriptors, $pipes);

            if (is_resource($process)) {
                proc_close($process);
            }

            // Save the backup file to your desired storage location
            //Storage::disk('local')->put('backups/' . $fileName, file_get_contents($backupPath)); //uses of storage/app folder
            Storage::disk('local')->putFileAs('database/seeders', $backupPath, $fileName);
            return response()->json([
                'code'=>0,
                'message'=>'success',
                'data'=>$backupPath
            ]);
        }
        catch(Exception $e)
        {
            $error_message ="Error: ".$e->getMessage()." in ".$e->getFile()." at line ".$e->getLine();
            return response()->json([
                'code'=>10,
                'message'=>$error_message,
                'data'=> [
                ]
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
    }
}