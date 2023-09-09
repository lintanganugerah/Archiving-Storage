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
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('user');
            $table->string('role');
            $table->string('judul_aktivitas');
            $table->string('aktivitas');
            $table->string('unit');
            $table->string('perangkat');
            $table->enum('recovery', ['ya', 'tidak'])->nullable();
            $table->integer('recovery_id')->nullable();
            $table->timestamps();

            $table->foreign('user')->references('name')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role')->references('role')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
