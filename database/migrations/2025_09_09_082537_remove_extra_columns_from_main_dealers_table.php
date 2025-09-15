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
    Schema::table('main_dealers', function (Blueprint $table) {
        $table->dropColumn(['jumlah_smk', 'diarsipkan', 'kurangnya', 'persentase', 'status']);
    });
}

public function down(): void
{
    Schema::table('main_dealers', function (Blueprint $table) {
        $table->integer('jumlah_smk')->default(0);
        $table->integer('diarsipkan')->default(0);
        $table->integer('kurangnya')->default(0);
        $table->float('persentase')->default(0);
        $table->enum('status', ['Lengkap', 'Tidak Lengkap'])->default('Tidak Lengkap');
    });
}

};
