<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$database = DB::getDatabaseName();
echo "Database: $database\n";
$tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = ?', [$database]);
foreach ($tables as $table) {
    echo $table->TABLE_NAME . "\n";
}
