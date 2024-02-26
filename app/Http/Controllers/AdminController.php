<?php

namespace App\Http\Controllers;

use App\Models\Display;
use App\Models\Grup;
use App\Models\Hadiah;
use App\Models\Peserta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Imports\PesertaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin.home');
    }

    public function listPeserta()
    {
        $pesertas = Peserta::all();
        return view('admin.list-peserta', compact('pesertas'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $excelData = Excel::toCollection(new PesertaImport, $file)[0];

        foreach ($excelData as $row) {
            // Check if the user already exists based on some unique criteria
            if(!empty($row['nama'])){

           
            $existingUser = Peserta::where('nama', $row['nama'])->first();

            if ($existingUser) {
                // Jika entri sudah ada, perbarui kolom yang kosong
                $existingUser->update([  
                    'nama' => $row['nama'],
                    'instansi' => $row['instansi'],
                    'ukuran_baju' => $row['ukuran_baju'],
                    'status' => $row['status'],
                    'id_grup' => $row['id_grup'],
                    'whatsapp' => $row['whatsapp'],
                ]);
            } else {
                // Jika entri belum ada, buat entri baru
                $newPeserta = Peserta::create([
                    'nama' => $row['nama'],
                    'instansi' => $row['instansi'],
                    'status' => $row['status'],
                    'ukuran_baju' => $row['ukuran_baju'],
                    'id_grup' => $row['id_grup'],
                    'whatsapp' => $row['whatsapp'],
                ]);

                $this->generateQRCodeIfNeeded($newPeserta);
            }
        }
        }

        $pesertas = Peserta::all();
        return  redirect()->route('admin.list.peserta', compact('pesertas'));
    }

    private function generateQRCodeIfNeeded($peserta)
    {
        $nama_file = strtoupper($peserta->nama) . '_' . strtoupper($peserta->instansi) . '.png';
        $path = 'qrcodes/' . $nama_file;

        // Periksa apakah QR code sudah ada
        if (!Storage::disk('public')->exists($path)) {
            // Jika QR code belum ada, generate QR code 
            $qrcode = QrCode::format('png')
            // ->merge(public_path('../../img/logogolf.png'), 0.3, true)
                ->merge('../public/img/logogolf.png', 0.3, true) // Menggabungkan logo dengan proporsi 30% terhadap ukuran QR code
                ->size(500)
                ->margin(3)
                ->generate($peserta->nama);

            // Simpan QR code sebagai gambar di direktori publik
            Storage::disk('public')->put($path, $qrcode);
        }
    }

    public function scan()
    {
        return view('admin.scan');
    }

    public function scanDo(Request $request)
    {
        // dd($request);
        $nama = $request->nama;
        $peserta = Peserta::where('nama', $nama)->first();
        if (!$peserta) {
            $request->session()->flash('message', 'Peserta belum terdaftar');
            $request->session()->flash('title', 'Gagal registrasi!');
            $request->session()->flash('icon', 'error');
            return redirect()->route('admin.scan');
        }
        if ($peserta && $peserta->status == 0 || $peserta->status == 1) {
            $peserta->status = 2;
            $peserta->save();
            $nama = $peserta->nama;
            $request->session()->flash('title', 'Berhasil Registrasi!');
            $request->session()->flash('message', 'Selamat ' . $nama . ', Anda berhasil melakukan registrasi');
            $request->session()->flash('icon', 'success');
            return redirect()->route('admin.scan');
        } else if ($peserta && $peserta->status == 2) {
            $nama = $peserta->nama;
            $request->session()->flash('message', 'Peserta Sudah Melakukan Registrasi Qrcode Atas Nama ' . $nama);
            $request->session()->flash('title', 'Gagal registrasi!');
            $request->session()->flash('icon', 'error');
            return redirect()->route('admin.scan');
        }
    }

    public function scanGunDo(Request $request) {
        $pesertas = Peserta::all();
        $nama = $request->nama;
        $peserta = Peserta::where('nama', $nama)->first();
        if (!$peserta) {
            $request->session()->flash('message', 'Peserta belum terdaftar');
            $request->session()->flash('title', 'Gagal registrasi!');
            $request->session()->flash('icon', 'danger');
            return redirect()->route('admin.list.peserta', compact('pesertas'));
        }
        if ($peserta && $peserta->status == 0 || $peserta->status == 1) {
            $peserta->status = 2;
            $peserta->save();
            $nama = $peserta->nama;
            $request->session()->flash('title', 'Berhasil Registrasi!');
            $request->session()->flash('message', 'Selamat ' . $nama . ', Anda berhasil melakukan registrasi');
            $request->session()->flash('icon', 'success');
            return redirect()->route('admin.list.peserta', compact('pesertas'));
        } else if ($peserta && $peserta->status == 2) {
            $nama = $peserta->nama;
            $request->session()->flash('message', 'Peserta Sudah Melakukan Registrasi Qrcode Atas Nama ' . $nama);
            $request->session()->flash('title', 'Gagal registrasi!');
            $request->session()->flash('icon', 'danger');
            return redirect()->route('admin.list.peserta', compact('pesertas'));
        }
    }

    public function listGrup()
    {
        $grups = Grup::all();
        return view('admin.list-grup', compact('grups'));
    }

    public function grupAdd(Request $request)
    {
        request()->validate([
            'nama_grup' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $grup = new Grup();
        $grup->nama_grup = $request->nama_grup;
        $grup->jumlah = $request->jumlah;
        $grup->save();
        return redirect()->route('admin.list.grup');
    }

    public function grupEdit(Request $request, $id)
    {
        $grup = Grup::find($id);
        request()->validate([
            'nama_grup_edit' => 'required',
            'jumlah_edit' => 'required|numeric'
        ]);

        $grup->nama_grup = $request->nama_grup_edit;
        $grup->jumlah = $request->jumlah_edit;
        $grup->save();
        return redirect()->route('admin.list.grup');
    }

    public function grupDelete($id)
    {
        // dd($id);
        $grup = Grup::find($id)->first();
        $grup->delete();
        return redirect()->route('admin.list.grup');
    }

    public function grupGenerate($id)
    {
        $grup = Grup::find($id);
        return view('admin.generate-grup', compact('grup'));
    }

    public function grupGenerateDo(Request $request)
    {
        $count = Peserta::where('id_grup', $request->id)->count();
        $jumlahHadiah = Grup::find($request->id)->jumlah;

        // Ngecek sisa
        $sisa = $jumlahHadiah - $count;

        if ($jumlahHadiah == $count && $sisa == 0) {
            return response()->json(['error' => 'Kuota hadiah sudah habis. Tidak dapat menambah anggota lagi.']);
        } else {
            $pesertaAcak = Peserta::where('status', 2)
                ->whereNull('id_grup')->inRandomOrder()->limit($sisa)->get();
            return response()->json(['peserta' => $pesertaAcak]);
        }
        // Ambil nama peserta secara acak sebanyak jumlah hadiah
    }

    public function grupGenerateLock(Request $request)
    {
        $request->validate([
            'anggota' => 'required|array',
            'id' => 'required|exists:tb_grup,id',
        ]);

        $grupId = $request->id;

        // Ambil hadiah berdasarkan ID
        $grup = Grup::find($grupId);

        if (!$grup) {
            return response()->json(['message' => 'Grup tidak ditemukan.']);
        }

        // Loop melalui array pemenang dan lakukan locking pada masing-masing peserta
        foreach ($request->input('anggota') as $pesertaData) {
            // Cari peserta berdasarkan NPP atau ID peserta, sesuaikan dengan struktur data yang dikirim dari frontend
            $peserta = Peserta::where('npp', $pesertaData['npp'])->first();

            if ($peserta) {
                // Ubah status dan isi id_grup pada peserta
                // $peserta->status = 2;  // Ganti sesuai status yang diinginkan
                $peserta->id_grup = $grup->id;
                $peserta->save();
            }
        }
        return response()->json(['message' => 'Anggota berhasil di-lock.']);
    }

    public function downloadQr($id)
    {
        $peserta = Peserta::find($id);
        $nama_file = $peserta->nama . '_' . $peserta->instansi . '.png';
        return response()->download(storage_path('app/public/qrcodes/' . $nama_file));
        // return response()->json(['url' => $url]);
    }


    public function listHadiah()
    {
        $hadiahs = Hadiah::all();
        return view('admin.list-hadiah', compact('hadiahs'));
    }

    public function hadiahAddDo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_hadiah' => 'required',
            'foto' => 'required|mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors->add('addHadiahErr', true);
            return redirect()->route('admin.list.hadiah')->withErrors($errors)->withInput();
        }
        $hadiah = new Hadiah();
        $gambar = $request->file('foto');
        $namaGambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(storage_path('app/public/images/'), $namaGambar);

        $hadiah->nama_hadiah = $request->nama_hadiah;
        $hadiah->jumlah = $request->jumlah;
        $hadiah->foto = $namaGambar;
        $hadiah->save();

        // Mendapatkan ID hadiah yang baru ditambahkan
        $newHadiahId = $hadiah->id;
        $display = new Display();
        $display->id_hadiah = $newHadiahId;
        $display->status = 0;
        $display->save();

        return redirect()->route('admin.list.hadiah');
    }


    /**
     * Update the specified resource in storage.
     */
    public function hadiahEditDo(Request $request, $id)
    {
        $hadiah = Hadiah::find($id);
        $validator = Validator::make($request->all(), [
            'nama_hadiah_edit' => 'required',
            'foto_edit' => 'mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors->add('addHadiahErrEdit', true);
            return redirect()->route('admin.list.hadiah')->withErrors($errors)->withInput();
        }

        if ($request->foto_edit) {

            $pathToImage = 'images/' . $hadiah->foto;
            if (Storage::disk('public')->exists($pathToImage)) {
                Storage::disk('public')->delete($pathToImage);
            }

            $gambar = $request->file('foto_edit');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(storage_path('app/public/images/'), $namaGambar);
            $hadiah->foto = $namaGambar;
        };

        $hadiah->nama_hadiah = $request->nama_hadiah_edit;
        $hadiah->jumlah = $request->jumlah_edit;
        $hadiah->save();
        return redirect()->route('admin.list.hadiah');
    }

    public function hadiahDeleteDo($id)
    {
        $hadiah = Hadiah::find($id);
        if ($hadiah) {

            // Hapus entri hadiah dari database
            $peserta = Peserta::where('id_hadiah', $id)->get();
            foreach ($peserta as $p) {
                $p->status = 2;
                $p->id_hadiah = NULL;
                $p->save();
            }

            // Hapus gambar terkait dari sistem file
            // $pathToImage = storage_path('app/public/images/') . $hadiah->foto;
            $pathToImage = 'images/' . $hadiah->foto;
            if (Storage::disk('public')->exists($pathToImage)) {
                Storage::disk('public')->delete($pathToImage);
            }

            $hadiah->delete();

            return redirect()->route('admin.list.hadiah')->with('success', 'Hadiah berhasil dihapus');
        } else {
            return redirect()->route('admin.list.hadiah')->with('error', 'Hadiah tidak ditemukan');
        }
    }

    public function generatePemenang($id)
    {
        $hadiah = Hadiah::find($id);
        return view('admin.generate-pemenang', compact('hadiah'));
    }

    public function generatePemenangDo(Request $request)
    {
        $count = Peserta::where('id_hadiah', $request->id)->count();
        $jumlahHadiah = Hadiah::find($request->id)->jumlah;

        // Ngecek sisa
        $sisa = $jumlahHadiah - $count;

        if ($jumlahHadiah == $count && $sisa == 0) {
            return response()->json(['error' => 'Kuota hadiah sudah habis. Tidak dapat mengundi lagi.']);
        } else {
            $pesertaAcak = Peserta::where('status', 2)
                ->whereNull('id_hadiah')->inRandomOrder()->limit($sisa)->get();
            return response()->json(['peserta' => $pesertaAcak]);
        }
    }

    public function lockPemenang(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'pemenang' => 'required|array',
            'id' => 'required|exists:tb_hadiah,id',
        ]);

        $hadiahId = $request->id;

        // Ambil hadiah berdasarkan ID
        $hadiah = Hadiah::find($hadiahId);

        if (!$hadiah) {
            return response()->json(['message' => 'Hadiah tidak ditemukan.']);
        }

        // Loop melalui array pemenang dan lakukan locking pada masing-masing peserta
        foreach ($request->input('pemenang') as $pesertaData) {
            // Cari peserta berdasarkan NPP atau ID peserta, sesuaikan dengan struktur data yang dikirim dari frontend
            $peserta = Peserta::where('id', $pesertaData['id'])->first();

            if ($peserta) {
                // Ubah status dan isi id_hadiah pada peserta
                $peserta->status = 3;  // Ganti sesuai status yang diinginkan
                $peserta->id_hadiah = $hadiah->id;
                $peserta->save();
            }
        }

        return response()->json(['message' => 'Pemenang berhasil di-lock.']);
    }

    public function flightView()
    {
        $grups = Grup::with(['peserta' => function ($query) {
            $query->where('status', 2)->orWhere('status', 3);
        }])->get();
        // $peserta = Peserta::where('status', 2);

        return view('admin.grup-view', compact('grups'));
    }
}
