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
        Schema::create('request_peminjaman_aset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('jumlah');
            $table->text('keterangan');
            $table->date('tanggal_permintaan');
            $table->enum('status_permintaan', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_permintaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_peminjaman_aset');
    }
};
