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
        Schema::create('transkasi_aset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('tipe_transaksi', ['peminjaman', 'pengembalian']);
            $table->string('kode_transaksi')->unique();
            $table->unsignedInteger('stok');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan');
            $table->date('tanggal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transkasi_aset');
    }
};
