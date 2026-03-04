<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$file = __DIR__ . '/database/factories/db alamat.sql';
if (!file_exists($file)) {
    die("File not found\n");
}

$sqlitePath = __DIR__ . '/database/factories/database.sqlite';
if (!file_exists($sqlitePath)) {
    touch($sqlitePath);
}

echo "Starting import...\n";

$sql = '';
$handle = fopen($file, 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $trimmed = trim($line);
        // Skip empty lines and comments
        if (empty($trimmed) || strpos($trimmed, '--') === 0 || strpos($trimmed, '/*') === 0) {
            continue;
        }

        $sql .= $line;

        if (substr($trimmed, -1, 1) == ';') {
            try {
                DB::connection('sqlite_wilayah')->unprepared($sql);
            }
            catch (\Exception $e) {
                echo "Error executing query: " . substr($sql, 0, 100) . "...\n";
                echo $e->getMessage() . "\n";
            }
            $sql = '';
        }
    }
    fclose($handle);
}

echo "Import finished!\n";
