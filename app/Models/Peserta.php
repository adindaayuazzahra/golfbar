<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'tb_peserta';

    public function hadiah()
    {
        return $this->belongsTo(Hadiah::class, 'id_hadiah');
    }

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup');
    }
}
