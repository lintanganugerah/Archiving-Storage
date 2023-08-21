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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek', 14);
            $table->string('nama');
            $table->string('cif', 7);
            $table->string('lokasi');
            $table->string('jenis');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditolak', 'menunggu 2']);
            $table->string('user');
            $table->timestamps();

            $table->foreign('cif')->references('cif')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nama')->references('nama')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lokasi')->references('lokasi')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('no_rek')->references('no_rek')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis')->references('jenis')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user')->references('name')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
