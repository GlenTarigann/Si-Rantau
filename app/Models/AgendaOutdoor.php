<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaOutdoor extends Model
{
    use HasFactory;

    // 1. Definisikan nama tabel secara eksplisit
    protected $table = 'tb_agenda_outdoor';

    // 2. Karena PK kita bukan 'id', harus dikasih tau
    protected $primaryKey = 'id_agenda';

    // 3. Kolom mana saja yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'nama_kegiatan',
        'lokasi_kota',
        'waktu_mulai',
        'prediksi_cuaca',
        'status_kegiatan'
    ];
}
