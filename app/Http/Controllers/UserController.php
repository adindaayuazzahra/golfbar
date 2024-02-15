<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('registrasi');
    }

    public function registerDo(Request $request)
    {
        request()->validate([
            'nama' => 'required',
            'npp' => 'required|unique:tb_peserta',
            'instansi' => 'required',
            'status' => 'required',
            'whatsapp' => 'required|numeric'
        ]);

        $peserta = new Peserta();
        $peserta->npp = strtoupper($request->npp);
        $peserta->nama = strtoupper($request->nama);
        $peserta->instansi = strtoupper($request->instansi);
        $peserta->whatsapp = $request->whatsapp;

        $nilaiStatus = ($request->status == 'y') ? 1 : 0;
        $peserta->status = $nilaiStatus;
        $peserta->save();

        // Make QRCODE
        $nama_file = strtoupper($request->nama) . '_' . strtoupper($request->instansi) . '.png';
        $qrcode = QrCode::format('png')->margin(4)->size(500)->generate($request->npp);

        // Simpan QR code sebagai gambar di direktori publik
        Storage::disk('public')->put('qrcodes/' . $nama_file, $qrcode);

        $request->session()->flash('message', 'Anda Berhasil Registrasi !');
        $request->session()->flash('title', 'Selamat');
        $request->session()->flash('icon', 'success');
        return redirect()->route('index');
    }
}
