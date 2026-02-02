<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateTables extends Command
{
    // The name and signature of the console command
    protected $signature = 'truncate:tables {tables*}';

    // The console command description
    protected $description = 'Truncate specified tables in the database';

    // Execute the console command
    public function handle()
    {
        // Get the list of tables passed as arguments
        $tables = $this->argument('tables');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            try {
                DB::table($table)->truncate();
                $this->info("Table '{$table}' truncated successfully.");
            } catch (\Exception $e) {
                $this->error("Failed to truncate table '{$table}': " . $e->getMessage());
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('All specified tables have been truncated.');
    }
}
