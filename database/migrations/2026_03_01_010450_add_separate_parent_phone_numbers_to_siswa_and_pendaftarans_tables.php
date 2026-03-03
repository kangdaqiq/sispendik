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
            if (!Schema::hasColumn('siswa', 'no_telp_ayah')) {
                $table->string('no_telp_ayah')->nullable()->after('pekerjaan_ayah');
            }
            if (!Schema::hasColumn('siswa', 'no_telp_ibu')) {
                $table->string('no_telp_ibu')->nullable()->after('pekerjaan_ibu');
            }
            if (Schema::hasColumn('siswa', 'no_telp_ortu')) {
                $table->dropColumn('no_telp_ortu');
            }
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftarans', 'no_telp_ayah')) {
                $table->string('no_telp_ayah')->nullable()->after('pekerjaan_ayah');
            }
            if (!Schema::hasColumn('pendaftarans', 'no_telp_ibu')) {
                $table->string('no_telp_ibu')->nullable()->after('pekerjaan_ibu');
            }
            if (Schema::hasColumn('pendaftarans', 'no_telp_ortu')) {
                $table->dropColumn('no_telp_ortu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('no_telp_ayah');
            $table->dropColumn('no_telp_ibu');
            $table->string('no_telp_ortu')->nullable()->after('pekerjaan_ibu'); // or similar
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('no_telp_ayah');
            $table->dropColumn('no_telp_ibu');
            $table->string('no_telp_ortu')->nullable()->after('pekerjaan_ibu');
        });
    }
};
