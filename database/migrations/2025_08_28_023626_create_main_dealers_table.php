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
        Schema::create('main_dealers', function (Blueprint $table) {
            $table->id();
            $table->string('md_code')->unique();
            $table->string('md_name');
            $table->integer('jumlah_smk')->default(0);
            $table->integer('diarsipkan');
            $table->integer('kurangnya');
            $table->float('persentase');
            $table->enum('status', ['Lengkap', 'Tidak Lengkap'])->default('Tidak Lengkap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_dealers');
    }
};
