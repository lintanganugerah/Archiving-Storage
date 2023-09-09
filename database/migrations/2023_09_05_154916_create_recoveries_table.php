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
        Schema::create('recoveries', function (Blueprint $table) {
            $table->id();
            $table->integer('berkas_id');
            $table->string('no_rek');
            $table->string('nama');
            $table->string('cif', 7);
            $table->string('agunan')->nullable();
            $table->string('jenis');
            $table->string('lokasi');
            $table->unsignedTinyInteger('ruang');
            $table->string('lemari', 2);
            $table->unsignedInteger('rak');
            $table->unsignedInteger('baris');
            $table->unsignedInteger('ruang_agunan')->nullable();
            $table->string('lemari_agunan', 2)->nullable();
            $table->unsignedInteger('rak_agunan')->nullable();
            $table->unsignedInteger('baris_agunan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recovery');
    }
};
