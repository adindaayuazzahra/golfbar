<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    use HasFactory;
    protected $table = 'tb_grup';

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'id_grup');
    }
}
