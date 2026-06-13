<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('order_id')->nullable()->unique()->after('id');
        });

        // Isi order_id untuk data pesanan yang sudah ada
        DB::table('pesanans')->get()->each(function ($pesanan) {
            DB::table('pesanans')->where('id', $pesanan->id)->update([
                'order_id' => 'PSN-' . str_pad($pesanan->id, 3, '0', STR_PAD_LEFT),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
