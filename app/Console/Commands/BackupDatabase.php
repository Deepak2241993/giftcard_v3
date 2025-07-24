<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ZipArchive;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a backup of the database and send it via email';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $backupFileName = "backup-{$timestamp}.sql";
        $backupFilePath = storage_path("app/backups/{$backupFileName}");

        // Ensure the backups directory exists
        if (!file_exists(dirname($backupFilePath))) {
            mkdir(dirname($backupFilePath), 0755, true);
        }

        // Build the mysqldump command securely
        $username = escapeshellarg(env('DB_USERNAME'));
        $password = escapeshellarg(env('DB_PASSWORD'));
        $database = escapeshellarg(env('DB_DATABASE'));

        $command = "mysqldump -u{$username} -p{$password} {$database} > " . escapeshellarg($backupFilePath);

        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error("Database backup failed!");
            return;
        }

        // Create ZIP file
        $zipFileName = pathinfo($backupFileName, PATHINFO_FILENAME) . '.zip';
        $zipFilePath = storage_path("app/backups/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($backupFilePath, $backupFileName);
            $zip->close();
        } else {
            $this->error("Failed to create ZIP file.");
            return;
        }

        // Send email with ZIP file
        $this->sendBackupEmail($zipFilePath);

        // Clean up files
        unlink($backupFilePath);
        unlink($zipFilePath);

        $this->info("Database backup completed and email sent!");
    }

    /**
     * Send the backup file via email.
     *
     * @param string $file
     * @return void
     */
  protected function sendBackupEmail($file)
    {
        $toEmail = 'deepakprasad224@gmail.com'; // Update as needed

        try {
            Mail::send([], [], function ($message) use ($toEmail, $file) {
                $message->to($toEmail)
                    ->subject('Database Backup - ' . Carbon::now()->format('Y-m-d'))
                    ->attach($file, [
                        'as' => 'database-backup.zip',
                        'mime' => 'application/zip',
                    ])
                    ->html('<p>Please find the database backup attached.</p>', 'text/html');
            });

            $this->info('Backup email sent successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to send backup email: ' . $e->getMessage());
            \Log::error('Backup email failed: ' . $e->getMessage());
        }
    }
}
