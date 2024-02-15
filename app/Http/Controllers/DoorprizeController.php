<?php

namespace App\Http\Controllers;

use App\Models\Display;
use App\Models\Hadiah;
use App\Models\Peserta;
use Illuminate\Http\Request;

class DoorprizeController extends Controller
{
    public function buttonGen()
    {
        return view('admin.button-trigger');
    }

    public function displayView()
    {
        return view('admin.doorprize');
    }

    public function ambilHadiah()
    {
        $hadiahs = Hadiah::all();
        return response()->json(['hadiah' => $hadiahs]);
    }

    public function display($id, $status)
    {
        $existingDisplay = Display::where('status', 1)->first();

        if ($existingDisplay) {
            // Jika ada, ubah statusnya menjadi 0
            $existingDisplay->status = 0;
            $existingDisplay->save();
        }
        $tb_display = Display::where('id_hadiah', $id)->first();
        $tb_display->status = $status;
        $tb_display->save();
        // Panggil fungsi displayPanggung dan teruskan nilai $id
        // $this->ambilDisplay($id);
        return response()->json(['message' => 'berhasil',]);
    }


    public function ambilDisplay()
    {

        $idHadiah = Display::where('status', 1)->first();
        $pesertaDaftar = Peserta::where('id_hadiah', $idHadiah->id_hadiah)->get();

        $hadiah = Hadiah::where('id', $idHadiah->id)->first();
        // $namaHadiah = $hadiah->nama_hadiah;
        // Lakukan operasi lain sesuai kebutuhan
        // Return atau tampilkan hasil sesuai kebutuhan Anda
        return response()->json(['pesertaDaftar' => $pesertaDaftar, 'message' => 'berhasil display panggung', 'hadiah' => $hadiah]);
    }
}
