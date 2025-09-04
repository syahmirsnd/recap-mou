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
        Schema::create('recaps', function (Blueprint $table) {
            $table->id();
            $table->enum('status_dokumen', [
                'Di Arsip',
                'Proses TTD (4)',
                'Proses TTD (3)',
                'Proses TTD (2)',
                'Dikembalikan',
                'Belum Diterima',
                'SMK Terminasi'
            ])->default('Belum Diterima');
            $table->foreignId('main_dealer_id')->constrained('main_dealers')->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recaps');
    }
};
