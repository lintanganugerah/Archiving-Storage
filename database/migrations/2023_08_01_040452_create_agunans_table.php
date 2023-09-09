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
        Schema::create('agunans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('cif', 7);
            $table->string('agunan');
            $table->string('Lokasi');
            $table->unsignedInteger('ruang_agunan');
            $table->string('lemari_agunan', 2);
            $table->unsignedInteger('rak_agunan');
            $table->unsignedInteger('baris_agunan');
            $table->timestamps();

            $table->foreign('cif')->references('cif')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nama')->references('nama')->on('berkas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agunans');
    }
};
