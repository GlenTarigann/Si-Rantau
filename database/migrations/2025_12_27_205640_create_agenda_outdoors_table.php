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
        Schema::create('tb_agenda_outdoor', function (Blueprint $table) {
            // pakai nama custom 'id_agenda', bukan 'id' bawaan
            $table->id('id_agenda'); 
        
            $table->string('nama_kegiatan', 100);
            $table->string('lokasi_kota', 50);
            $table->dateTime('waktu_mulai');
        
            // Ini nullable karena isinya didapat dari API (bukan input user)
            // Jadi kalau API error, data tetap bisa masuk (opsional)
            $table->string('prediksi_cuaca', 50)->nullable();
        
            $table->enum('status_kegiatan', ['Scheduled', 'Done', 'Canceled'])->default('Scheduled');
        
            $table->timestamps(); // Ini wajib untuk created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_outdoors');
    }
};
