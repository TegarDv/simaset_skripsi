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
            $table->integer('id_user');
            $table->string('tipe_aset');
            $table->string('kode_aset');
            $table->string('nama_aset');
            $table->integer('jumlah');
            $table->bigInteger('harga');
            $table->text('spesifikasi');
            $table->text('keterangan');
            $table->integer('status');
            $table->integer('kondisi_aset');
            $table->date('masa_berlaku');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
