<?php

namespace App\Http\Controllers;

use App\Models\Display;
use App\Models\Hadiah;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoorprizeController extends Controller
{


    public function  getAllPeserta()
    {
        $peserta = Peserta::all();
        return response()->json($peserta);
    }

    public function displayView()
    {
        $hadiahs = Hadiah::all();
        return view('admin.doorprize', compact('hadiahs'));
    }


    public function getFotoHadiah($id)
    {
        $hadiah = Hadiah::find($id);
        $img =  Storage::url('public/images/' . $hadiah->foto);
        if ($hadiah) {
            return response()->json(['foto' => $img]);
        }
        return response()->json(['foto' => null]);
    }

    public function getPemenang($hadiah_id)
    {
        $pemenangList = Peserta::where('id_hadiah', $hadiah_id)
            ->get();
        return response()->json($pemenangList);
    }


    public function getReset($hadiah_id)
    {
        Peserta::where('id_hadiah', $hadiah_id)
            ->update(['id_hadiah' => null, 'status' => 2]);

        $hadiah = Hadiah::find($hadiah_id);
        $pemenangList = Peserta::whereNull('id_hadiah')->inRandomOrder()->limit($hadiah->jumlah)->get();

        foreach ($pemenangList as $peserta) {
            $peserta->update([
                'id_hadiah' => $hadiah_id,
                'status' => 3
            ]);
        }

        return response()->json($pemenangList);
    }

    public function buttonGen()
    {
        return view('admin.button-trigger');
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
