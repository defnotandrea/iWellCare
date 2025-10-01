<?php

/**
 * iWellCare Database Export Script
 * This script exports the database structure and data
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "Starting iWellCare Database Export...\n";
    echo "=====================================\n\n";

    // Get database name
    $databaseName = config('database.connections.mysql.database');
    echo "Database: {$databaseName}\n";

    // Get all tables
    $tables = DB::select('SHOW TABLES');
    $tableName = 'Tables_in_'.$databaseName;

    echo 'Found '.count($tables)." tables\n\n";

    $exportContent = "-- iWellCare Database Export\n";
    $exportContent .= '-- Generated on: '.date('Y-m-d H:i:s')."\n";
    $exportContent .= "-- Database: {$databaseName}\n\n";
    $exportContent .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    $exportContent .= "SET AUTOCOMMIT = 0;\n";
    $exportContent .= "START TRANSACTION;\n";
    $exportContent .= "SET time_zone = \"+00:00\";\n\n";

    foreach ($tables as $table) {
        $tableName = $table->$tableName;
        echo "Exporting table: {$tableName}\n";

        // Get table structure
        $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
        $exportContent .= "-- Table structure for table `{$tableName}`\n";
        $exportContent .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
        $exportContent .= $createTable[0]->{'Create Table'}.";\n\n";

        // Get table data
        $rows = DB::table($tableName)->get();
        if ($rows->count() > 0) {
            $exportContent .= "-- Data for table `{$tableName}`\n";
            $exportContent .= "INSERT INTO `{$tableName}` VALUES\n";

            $values = [];
            foreach ($rows as $row) {
                $rowData = [];
                foreach ($row as $key => $value) {
                    if ($value === null) {
                        $rowData[] = 'NULL';
                    } else {
                        $rowData[] = "'".addslashes($value)."'";
                    }
                }
                $values[] = '('.implode(', ', $rowData).')';
            }

            $exportContent .= implode(",\n", $values).";\n\n";
        } else {
            $exportContent .= "-- No data for table `{$tableName}`\n\n";
        }
    }

    $exportContent .= "COMMIT;\n";

    // Save to file
    $filename = 'iwellcare_export_'.date('Y-m-d_H-i-s').'.sql';
    file_put_contents($filename, $exportContent);

    echo "\nExport completed successfully!\n";
    echo "File saved as: {$filename}\n";
    echo 'File size: '.number_format(filesize($filename))." bytes\n";

} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
    echo "This might be because MySQL is not running.\n";
    echo "Please start MySQL in XAMPP and try again.\n";
}
