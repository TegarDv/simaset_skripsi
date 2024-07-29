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
        Schema::create('data_status', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status');
            $table->enum('color', ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'])->default('primary');
            $table->enum('kategori', ['normal', 'rusak'])->default('normal');
            $table->decimal('biaya_perbaikan', 3, 2)->default(0); // 3 total digits, 2 of them after the decimal point
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_status');
    }
};
