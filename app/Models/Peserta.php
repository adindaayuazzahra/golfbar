<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'tb_peserta';
    protected $fillable = [
        'id',
        'nama',
        'status',
        'instansi',
        'ukuran_baju',
        'id_grup',
        'id_hadiah',
        'whatsapp',
        // tambahkan kolom-kolom lain yang dapat diisi secara massal di sini jika ada
    ];

    public function hadiah()
    {
        return $this->belongsTo(Hadiah::class, 'id_hadiah');
    }

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup');
    }
}
