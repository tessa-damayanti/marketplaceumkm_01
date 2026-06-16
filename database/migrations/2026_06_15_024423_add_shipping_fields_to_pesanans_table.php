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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('nama_penerima')->nullable()->after('snap_token');
            $table->string('no_wa_penerima')->nullable()->after('nama_penerima');
            $table->text('alamat_penerima')->nullable()->after('no_wa_penerima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['nama_penerima', 'no_wa_penerima', 'alamat_penerima']);
        });
    }
};
