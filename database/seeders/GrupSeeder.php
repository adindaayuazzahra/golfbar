<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 16; $i++) {
            DB::table('tb_grup')->insert([
                'nama_grup' => 'flight ' . $i,
                'jumlah' => 4,
            ]);
        }
    }
}
