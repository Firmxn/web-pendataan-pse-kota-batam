<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasColumn('pses', 'domain_name')) {
            DB::statement("ALTER TABLE pses RENAME COLUMN domain_name TO subdomain_name");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasColumn('pses', 'subdomain_name')) {
            DB::statement("ALTER TABLE pses RENAME COLUMN subdomain_name TO domain_name");
        }
    }
};
