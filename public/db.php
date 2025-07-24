<?php
// Set database credentials
$dbHost = 'localhost';
$dbUser = 'u929332160_giftcards';
$dbPass = 'Z2$;6J=d0';
$dbName = 'u929332160_giftcards';

// Absolute path to the Laravel public folder
$backupDir = __DIR__ . '/uploads';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true); // create uploads dir if it doesn't exist
}

$backupFile = $backupDir . "/backup_{$dbName}_" . date('Y-m-d_H-i-s') . ".sql";

// Run the mysqldump command
$command = "mysqldump --user={$dbUser} --password=\"{$dbPass}\" --host={$dbHost} {$dbName} > {$backupFile}";
system($command);

// Check if the backup file was created
if (file_exists($backupFile)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($backupFile) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backupFile));

    ob_clean();
    flush();
    readfile($backupFile);
    unlink($backupFile);
    exit;
} else {
    echo "Backup failed.";
}
?>
