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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('main_dealer_id')
              ->nullable()
              ->after('role')
              ->constrained('main_dealers')
              ->restrictOnDelete();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['main_dealer_id']);
        $table->dropColumn('main_dealer_id');
    });
}

};
