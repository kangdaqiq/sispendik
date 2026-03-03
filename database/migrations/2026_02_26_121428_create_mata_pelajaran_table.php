<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();   // e.g. "MTK", "BIN"
            $table->string('nama');
            $table->string('kelompok')->nullable(); // e.g. "Wajib A", "Wajib B", "Peminatan"
            $table->integer('kkm')->default(75); // Nilai minimum kelulusan
            $table->integer('jam_per_minggu')->default(2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
