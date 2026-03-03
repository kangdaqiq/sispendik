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
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nama_panggilan')->nullable()->after('nama');
            $table->string('sekolah_asal')->nullable()->after('no_telp');
            $table->integer('anak_ke')->nullable()->after('sekolah_asal');
            $table->integer('dari_bersaudara')->nullable()->after('anak_ke');
            $table->enum('status_anak', ['kandung', 'tiri', 'angkat'])->nullable()->after('dari_bersaudara');
            $table->integer('berat_badan')->nullable()->after('status_anak');
            $table->integer('tinggi_badan')->nullable()->after('berat_badan');
            $table->string('provinsi')->nullable()->after('alamat');
            $table->string('kabupaten')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kabupaten');
            $table->string('desa')->nullable()->after('kecamatan');
            $table->text('alamat_detail')->nullable()->after('desa');

            $table->enum('status_ayah', ['masih_hidup', 'sudah_meninggal'])->nullable()->after('alamat_detail');
            $table->string('pendidikan_ayah')->nullable()->after('nama_ortu');
            $table->string('pekerjaan_ayah')->nullable()->after('pendidikan_ayah');

            $table->enum('status_ibu', ['masih_hidup', 'sudah_meninggal'])->nullable()->after('pekerjaan_ayah');
            $table->string('nama_ibu')->nullable()->after('status_ibu');
            $table->string('pendidikan_ibu')->nullable()->after('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable()->after('pendidikan_ibu');

            $table->string('nama_wali')->nullable()->after('no_telp_ortu');
            $table->string('pendidikan_wali')->nullable()->after('nama_wali');
            $table->string('pekerjaan_wali')->nullable()->after('pendidikan_wali');
            $table->string('no_telp_wali')->nullable()->after('pekerjaan_wali');

            $table->boolean('alamat_ortu_sama')->default(true)->after('no_telp_wali');
            $table->string('provinsi_ortu')->nullable()->after('alamat_ortu_sama');
            $table->string('kabupaten_ortu')->nullable()->after('provinsi_ortu');
            $table->string('kecamatan_ortu')->nullable()->after('kabupaten_ortu');
            $table->string('desa_ortu')->nullable()->after('kecamatan_ortu');
            $table->text('alamat_detail_ortu')->nullable()->after('desa_ortu');
            $table->string('rt_ortu')->nullable()->after('alamat_detail_ortu');
            $table->string('rw_ortu')->nullable()->after('rt_ortu');
            $table->string('kode_pos_ortu')->nullable()->after('rw_ortu');

            $table->string('foto_kk')->nullable()->after('foto');
            $table->string('foto_ktp_ortu')->nullable()->after('foto_kk');
            $table->string('ijazah_terakhir')->nullable()->after('foto_ktp_ortu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'nama_panggilan',
                'sekolah_asal',
                'anak_ke',
                'dari_bersaudara',
                'status_anak',
                'berat_badan',
                'tinggi_badan',
                'provinsi',
                'kabupaten',
                'kecamatan',
                'desa',
                'alamat_detail',
                'status_ayah',
                'pendidikan_ayah',
                'pekerjaan_ayah',
                'status_ibu',
                'nama_ibu',
                'pendidikan_ibu',
                'pekerjaan_ibu',
                'nama_wali',
                'pendidikan_wali',
                'pekerjaan_wali',
                'no_telp_wali',
                'alamat_ortu_sama',
                'provinsi_ortu',
                'kabupaten_ortu',
                'kecamatan_ortu',
                'desa_ortu',
                'alamat_detail_ortu',
                'rt_ortu',
                'rw_ortu',
                'kode_pos_ortu',
                'foto_kk',
                'foto_ktp_ortu',
                'ijazah_terakhir'
            ]);
        });
    }
};
