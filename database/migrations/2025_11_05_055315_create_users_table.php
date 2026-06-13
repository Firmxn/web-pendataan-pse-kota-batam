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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->nullable()->constrained('opds')->onDelete('set null');
            $table->foreignId('role_id')->constrained('roles')->onDelete('restrict');
            $table->string('name', 150);
            $table->string('email', 150)->unique();
            $table->string('password', 130);
            $table->string('phone_number', 30)->nullable();
            $table->string('nip', 30)->unique()->nullable();
            $table->string('position', 100)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('work_unit', 100)->nullable();
            $table->string('work_unit_phone', 30)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
