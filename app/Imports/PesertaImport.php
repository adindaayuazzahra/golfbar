<?php

namespace App\Imports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Peserta([
            'id' => $row['id'],
            'nama' => $row['nama'],
            'instansi'=> $row['instansi'], 
            'ukuran_baju' => $row['ukuran_baju'], 
            'status' => $row['status'], 
            'id_grup' => $row['id_grup'], 
            'whatsapp' => $row['whatsapp'], 
        ]);
    }
}
