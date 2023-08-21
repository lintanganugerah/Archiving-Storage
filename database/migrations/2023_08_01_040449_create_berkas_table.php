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
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek', 14)->index();
            $table->string('nama')->index();
            $table->string('cif', 7)->unique();
            $table->string('agunan')->nullable()->index();
            $table->string('jenis')->index();
            $table->string('lokasi')->index();
            $table->unsignedTinyInteger('ruang');
            $table->string('lemari', 2)->index();
            $table->unsignedInteger('rak')->index();
            $table->unsignedInteger('baris')->index();
            $table->string('status')->default('ada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
