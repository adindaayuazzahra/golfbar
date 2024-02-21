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
            // 'npp' => 'required|unique:tb_peserta',
            'instansi' => 'required',
            'status' => 'required',
            'whatsapp' => 'required|numeric',
            'ukuran_baju' => 'required'
        ]);

        $peserta = new Peserta();
        // $peserta->npp = strtoupper($request->npp);
        $peserta->nama = strtoupper($request->nama);
        $peserta->instansi = strtoupper($request->instansi);
        $peserta->whatsapp = $request->whatsapp;
        $peserta->ukuran_baju = $request->ukuran_baju;

        $nilaiStatus = ($request->status == 'y') ? 1 : 0;
        $peserta->status = $nilaiStatus;
        $peserta->save();

        // Make QRCODE
        $nama_file = strtoupper($request->nama) . '_' . strtoupper($request->instansi) . '.png';
        $qrcode = QrCode::format('png')
        ->merge('../public/img/logogolf.png', 0.5, true) // Menggabungkan logo dengan proporsi 30% terhadap ukuran QR code
        ->size(500)
        ->margin(3)
        ->generate($request->nama);
        // QrCode::format('png')->margin(4)->size(500)->generate($request->nama);

        // Simpan QR code sebagai gambar di direktori publik
        Storage::disk('public')->put('qrcodes/' . $nama_file, $qrcode);

        $request->session()->put('form_filled', true);

        return redirect()->route('berhasil.regis');
    }

    public function BerhasilRegis()  {
        return view('admin.konfirmasi');
    }
}
