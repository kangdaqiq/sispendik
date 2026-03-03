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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('no_telp_ortu');
            $table->string('no_telp_ayah')->nullable()->after('pekerjaan_ayah');
            $table->string('no_telp_ibu')->nullable()->after('pekerjaan_ibu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('no_telp_ortu')->nullable();
            $table->dropColumn(['no_telp_ayah', 'no_telp_ibu']);
        });
    }
};
