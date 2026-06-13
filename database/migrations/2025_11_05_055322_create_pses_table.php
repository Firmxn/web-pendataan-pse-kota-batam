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
        Schema::create('pses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('opd_id')->constrained('opds')->onDelete('cascade');
            $table->string('system_name', 150)->unique();
            $table->string('sector', 100);
            $table->string('pic_name', 150);
            $table->string('pic_phone', 30);
            $table->string('pic_email', 150);
            $table->string('url', 255)->unique()->nullable();
            $table->string('subdomain_name', 255)->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('risk_category', 80);
            $table->string('data_classification', 80);
            $table->text('private_data_info')->nullable();
            $table->text('storage_location');
            $table->string('status', 30)->default('draft');
            $table->string('registration_number', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pses');
    }
};
