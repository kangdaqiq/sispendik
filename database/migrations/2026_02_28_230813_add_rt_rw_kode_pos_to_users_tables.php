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
            $table->string('rt', 5)->nullable()->after('alamat');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kode_pos', 10)->nullable()->after('rw');
        });

        Schema::table('guru', function (Blueprint $table) {
            $table->string('rt', 5)->nullable()->after('alamat');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kode_pos', 10)->nullable()->after('rw');
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('rt', 5)->nullable()->after('alamat_detail');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kode_pos', 10)->nullable()->after('rw');

            $table->string('rt_ortu', 5)->nullable()->after('alamat_detail_ortu');
            $table->string('rw_ortu', 5)->nullable()->after('rt_ortu');
            $table->string('kode_pos_ortu', 10)->nullable()->after('rw_ortu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'kode_pos']);
        });

        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'kode_pos']);
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'kode_pos', 'rt_ortu', 'rw_ortu', 'kode_pos_ortu']);
        });
    }
};
