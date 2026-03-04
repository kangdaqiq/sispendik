<?php

use Illuminate\Support\Facades\DB;

$path = database_path('factories/db alamat.sql');
$sqlitePath = database_path('factories/database.sqlite');
if (!file_exists($sqlitePath)) {
    touch($sqlitePath);
}

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
            $queryToExec = str_replace('COLLATE "pg_catalog"."default"', '', $query);
            $queryToExec = str_replace('int4', 'INTEGER', $queryToExec);

            DB::connection('sqlite_wilayah')->unprepared($queryToExec);
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
