<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            if (Schema::hasColumn('opds', 'opd_name')) {
                $table->renameColumn('opd_name', 'name');
            }
            if (Schema::hasColumn('opds', 'official_email')) {
                $table->renameColumn('official_email', 'email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            if (Schema::hasColumn('opds', 'name')) {
                $table->renameColumn('name', 'opd_name');
            }
            if (Schema::hasColumn('opds', 'email')) {
                $table->renameColumn('email', 'official_email');
            }
        });
    }
};
