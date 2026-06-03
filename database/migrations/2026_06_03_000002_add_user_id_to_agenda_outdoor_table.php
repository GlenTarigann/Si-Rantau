<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_agenda_outdoor', function (Blueprint $table) {
            // Tambah user_id setelah id_agenda, nullable agar data lama tidak error
            $table->unsignedBigInteger('user_id')->nullable()->after('id_agenda');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tb_agenda_outdoor', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
