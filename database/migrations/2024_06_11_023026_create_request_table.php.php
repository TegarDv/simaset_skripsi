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
        Schema::create('permintaan_aset', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_aset');
            $table->string('nama_aset');
            $table->unsignedBigInteger('harga');
            $table->text('spesifikasi');
            $table->text('keterangan');
            $table->unsignedInteger('stok_permintaan');
            $table->unsignedBigInteger('pemilik_aset');
            $table->foreign('pemilik_aset')->references('id')->on('users');
            $table->date('masa_berlaku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_aset');
    }
};
