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
        Schema::create('pinjams', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek', 14);
            $table->string('nama');
            $table->string('cif', 7);
            $table->string('jenis');
            $table->string('lokasi');
            $table->string('lemari', 2);
            $table->unsignedInteger('rak');
            $table->unsignedInteger('baris');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditolak', 'proses pengembalian']);
            $table->string('user');
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('cif')->references('cif')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nama')->references('nama')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('no_rek')->references('no_rek')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis')->references('jenis')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lemari')->references('lemari')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rak')->references('rak')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('baris')->references('baris')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user')->references('name')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjams');
    }
};
