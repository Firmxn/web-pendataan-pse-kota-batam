<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pses', function (Blueprint $table) {
            // Hapus kolom yang redundan
            $table->dropColumn(['subdomain_name', 'url']);
        });

        Schema::table('subdomain_requests', function (Blueprint $table) {
            // Tambahkan is_primary untuk menandai subdomain utama di list
            $table->boolean('is_primary')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pses', function (Blueprint $table) {
            // Restore kolom jika rollback
            $table->string('url')->nullable()->after('pic_email');
            $table->string('subdomain_name')->nullable()->after('url');
        });

        Schema::table('subdomain_requests', function (Blueprint $table) {
            $table->dropColumn('is_primary');
        });
    }
};
