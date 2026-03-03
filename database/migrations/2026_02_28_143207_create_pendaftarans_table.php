<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('no_kk');
            $table->string('nama');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('no_telp');
            $table->string('sekolah_asal');

            // Detail Keluarga & Fisik
            $table->integer('anak_ke');
            $table->integer('dari_bersaudara');
            $table->enum('status_anak', ['kandung', 'tiri', 'angkat']);
            $table->integer('berat_badan');
            $table->integer('tinggi_badan');

            // Detail Alamat Siswa
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->text('alamat_detail');

            // Data Bapak
            $table->enum('status_ayah', ['masih_hidup', 'sudah_meninggal'])->default('masih_hidup');
            $table->string('nama_ayah');
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();

            // Data Ibu
            $table->enum('status_ibu', ['masih_hidup', 'sudah_meninggal'])->default('masih_hidup');
            $table->string('nama_ibu');
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();

            // No Telp Orang Tua (nullable if both deceased)
            $table->string('no_telp_ortu')->nullable();

            // Data Wali
            $table->string('nama_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('no_telp_wali')->nullable();

            // Detail Alamat Ortu
            $table->boolean('alamat_ortu_sama')->default(true);
            $table->string('provinsi_ortu')->nullable();
            $table->string('kabupaten_ortu')->nullable();
            $table->string('kecamatan_ortu')->nullable();
            $table->string('desa_ortu')->nullable();
            $table->text('alamat_detail_ortu')->nullable();

            // Uploads
            $table->string('foto_kk');
            $table->string('foto_ktp_ortu')->nullable();
            $table->string('ijazah_terakhir');

            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
