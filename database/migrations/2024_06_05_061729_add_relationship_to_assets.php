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
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('status_aset')->after('tanggal_penerimaan');
            $table->unsignedBigInteger('kondisi_aset')->after('status_aset');
            $table->unsignedBigInteger('lokasi_aset')->after('kondisi_aset');
            $table->unsignedBigInteger('pemilik_aset')->after('lokasi_aset');
            $table->foreign('pemilik_aset')->references('id')->on('users');
            $table->foreign('status_aset')->references('id')->on('data_status');
            $table->foreign('kondisi_aset')->references('id')->on('data_status');
            $table->foreign('lokasi_aset')->references('id')->on('asset_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
};
