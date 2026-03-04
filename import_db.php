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
    DB::connection('sqlite_wilayah')->beginTransaction();
    $query = '';
    $count = 0;
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if (empty($line) || strpos($line, '--') === 0) {
            continue;
        }

        $query .= $line . "\n";

        if (substr(trim($line), -1, 1) == ';') {
            $queryToExec = preg_replace('/COLLATE\s+["\']?pg_catalog["\']?\.["\']?default["\']?/i', '', $query);
            $queryToExec = str_ireplace('int4', 'INTEGER', $queryToExec);

            DB::connection('sqlite_wilayah')->unprepared($queryToExec);
            $query = '';
            $count++;

            if ($count % 5000 == 0) {
                echo "Imported $count queries...\n";
            }
        }
    }
    fclose($handle);
    DB::connection('sqlite_wilayah')->commit();
    echo "Done importing $count queries.\n";
}
else {
    echo "Error opening file.\n";
}
