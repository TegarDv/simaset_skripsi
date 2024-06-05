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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('id_user');
            $table->string('tipe_aset');
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->integer('jumlah');
            $table->bigInteger('harga');
            $table->text('spesifikasi');
            $table->text('keterangan');
            // $table->unsignedInteger('status_aset');
            // $table->unsignedInteger('kondisi_aset');
            $table->integer('stok_awal');
            $table->integer('stok_sekarang');
            // $table->unsignedInteger('lokasi_aset');
            $table->date('masa_berlaku');
            $table->date('tanggal_penerimaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};