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
            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('color', ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'])
                    ->default('primary');
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
