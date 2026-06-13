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
        Schema::create('hosting_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('pse_id')->constrained('pses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('request_type', 30); // baru, perpanjangan, ubah, hapus
            $table->string('hosting_type', 30); // shared, vps, dedicated, cloud
            $table->integer('cpu_cores')->unsigned(); // jumlah core CPU
            $table->integer('ram_capacity')->unsigned(); // dalam GB
            $table->integer('storage_capacity')->unsigned(); // dalam GB
            $table->integer('bandwidth_capacity')->unsigned(); // dalam GB/bulan
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('draft'); // draft, pending_1, pending_2, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_requests');
    }
};
