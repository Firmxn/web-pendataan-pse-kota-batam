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
        Schema::table('pses', function (Blueprint $table) {
            $table->foreignId('opd_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pses', function (Blueprint $table) {
            // Revert changes
            $table->foreignId('opd_id')->nullable(false)->change();
        });
    }
};
