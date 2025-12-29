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
        Schema::table('ibadah', function (Blueprint $table) {
            $table->time('time')->nullable()->after('prayer_name');             
            $table->integer('target_count')->nullable()->after('kategori');
            $table->string('target_unit')->nullable()->after('target_count');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ibadah', function (Blueprint $table) {
        $table->dropColumn(['target_count', 'target_unit', 'time', 'notes']);
        });
    }
};
