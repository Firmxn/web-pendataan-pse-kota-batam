<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Langkah 1: Tambah kolom uuid (skip jika sudah ada dari run sebelumnya yang gagal)
        if (!Schema::hasColumn('documents', 'uuid')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->after('id');
            });
        }

        // Langkah 2: Populate UUID untuk semua row yang belum punya uuid
        DB::table('documents')
            ->whereNull('uuid')
            ->orWhere('uuid', '')
            ->orderBy('id')
            ->each(function ($doc) {
                DB::table('documents')
                    ->where('id', $doc->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            });

        // Langkah 3: Tambahkan NOT NULL + unique constraint
        Schema::table('documents', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Hapus kolom uuid saat rollback
            $table->dropColumn('uuid');
        });
    }
};
