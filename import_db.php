<?php

use Illuminate\Support\Facades\DB;

$path = database_path('factories/db alamat.sql');
$handle = fopen($path, 'r');

if ($handle) {
    echo "Importing...\n";
    $query = '';
    $count = 0;
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if (empty($line) || strpos($line, '--') === 0) {
            continue;
        }

        $query .= $line . "\n";

        if (substr(trim($line), -1, 1) == ';') {
            DB::connection('sqlite_wilayah')->unprepared($query);
            $query = '';
            $count++;

            if ($count % 5000 == 0) {
                echo "Imported $count queries...\n";
            }
        }
    }
    fclose($handle);
    echo "Done importing $count queries.\n";
}
else {
    echo "Error opening file.\n";
}
