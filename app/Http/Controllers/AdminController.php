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
use Intervention\Image\ImageManager;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    // protected $imageManager;

    // public function __construct(ImageManager $imageManager)
    // {
    //     $this->imageManager = $imageManager;
    // }

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
            if (!empty($row['nama'])) {


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
                    $oldFile = $existingUser->nama . '_' . $existingUser->instansi . '.png';
                    $oldPath = 'qrcodes/' . $oldFile;
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }

                    $this->generateQRCodeIfNeeded($existingUser);
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

    // private function generateQRCodeIfNeeded($peserta)
    // {
    //     $nama_file = $peserta->nama . '_' . $peserta->instansi . '.png';
    //     $path = 'qrcodes/' . $nama_file;

    //     // Periksa apakah QR code sudah ada
    //     if (!Storage::disk('public')->exists($path)) {
    //         // Jika QR code belum ada, generate QR code 
    //         $qrcode = QrCode::format('png')
    //             // ->merge(public_path('../../img/logogolf.png'), 0.3, true)
    //             ->merge('../public/img/logogolf.png', 0.3, true) // Menggabungkan logo dengan proporsi 30% terhadap ukuran QR code
    //             ->size(500)
    //             ->margin(3)
    //             ->generate($peserta->nama);

    //         // Simpan QR code sebagai gambar di direktori publik
    //         Storage::disk('public')->put($path, $qrcode);
    //     }
    // }


    private function generateQRCodeIfNeeded($peserta)
    {
        $nama_file = $peserta->nama . '_' . $peserta->instansi . '.png';
        $path = 'qrcodes/' . $nama_file;

        $dataPlain = $peserta->id . '|' . $peserta->nama . '|' . $peserta->instansi;
        $dataEncoded = base64_encode($dataPlain);

        if (!Storage::disk('public')->exists($path)) {
            $qrContent = QrCode::format('png')
                ->merge(public_path('img/logogolf.png'), 0.3, true)
                ->size(500)
                ->margin(2)
                ->generate($dataEncoded);
            Storage::disk('public')->put($path, $qrContent);
            // $imageManager = app(ImageManager::class);

            // // Buat file sementara QR
            // $tempFile = storage_path('app/temp_qr_' . Str::random(10) . '.png');

            // QrCode::format('png')
            //     ->merge(public_path('img/logogolf.png'), 0.3, true)
            //     ->size(500)
            //     ->margin(2)
            //     ->generate($dataEncoded, $tempFile);

            // $qrImage = file_get_contents($tempFile);
            // $qr = $imageManager->read($qrImage);

            // // Tambahkan padding atas untuk nama
            // $paddingTop = 80;
            // $canvas = $imageManager->create($qr->width(), $qr->height() + $paddingTop, 'ffffff');
            // // Isi latar belakang manual dengan putih
            // $canvas->fill('ffffff');

            // // $canvas->place($qr);
            // $canvas->place($qr, 'top', 0, $paddingTop);

            // // Tambahkan nama di atas QR
            // $canvas->text($peserta->nama, $qr->width() / 2, 10, function ($font) {
            //     $font->filename(public_path('fonts/arial/ARIALBD.TTF')); // Menggunakan font bold
            //     $font->size(22);
            //     $font->color('000000');
            //     $font->align('center');
            //     $font->valign('top');
            // });

            // $canvas->text($peserta->instansi, $qr->width() / 2, 35, function ($font) {
            //     $font->filename(public_path('fonts/arial/ARIALBD.TTF')); // Menggunakan font bold
            //     $font->size(20);
            //     $font->color('000000');
            //     $font->align('center');
            //     $font->valign('top');
            // });

            // $canvas->text('ID0' . $peserta->id, $qr->width() / 2, 60, function ($font) {
            //     $font->filename(public_path('fonts/arial/ARIALBD.TTF')); // Menggunakan font bold
            //     $font->size(20);
            //     $font->color('000000');
            //     $font->align('center');
            //     $font->valign('top');
            // });

            // // Simpan hasil ke storage
            // Storage::disk('public')->put($path, (string) $canvas->toPng());

            // Hapus file sementara
            // @unlink($tempFile);
        }
    }



    // private function generateQRCodeIfNeeded($peserta)
    // {
    //     $nama_file = strtoupper($peserta->nama) . '_' . strtoupper($peserta->instansi) . '.png';
    //     $path = 'qrcodes/' . $nama_file;

    //     // Periksa apakah QR code sudah ada
    //     if (!Storage::disk('public')->exists($path)) {
    //         // Jika QR code belum ada, generate QR code 
    //         $qrCode = QrCode::format('png')
    //             ->merge('../public/img/logogolf.png', 0.3, true) // Menggabungkan logo dengan proporsi 30% terhadap ukuran QR code
    //             ->size(500)
    //             ->margin(3)
    //             ->generate($peserta->nama);

    //         // Tambahkan teks di bawah barcode

    //         $image = Image::make($qrCode);
    //         $text = strtoupper($peserta->nama); // Teks yang akan ditambahkan
    //         $image->text($text, $image->width() / 2, $image->height() + 20, function ($font) {
    //             $font->file(public_path('fonts/arial.ttf')); // Path ke font yang akan digunakan
    //             $font->size(24); // Ukuran font
    //             $font->color('#000000'); // Warna teks (dalam format hex)
    //             $font->align('center'); // Posisi teks (center)
    //             $font->valign('bottom'); // Posisi teks (bottom)
    //         });

    //         // Simpan QR code dengan teks sebagai gambar di direktori publik
    //         Storage::disk('public')->put($path, $image->encode());
    //     }

    //     // // Setelah QR code dibuat atau jika sudah ada, Anda dapat mengembalikan respons download seperti yang Anda lakukan sebelumnya
    //     // return response()->download(storage_path('app/public/' . $path));
    // }


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

    public function scanGunDo(Request $request)
    {
        $pesertas = Peserta::all();
        $qrResult = $request->input('qr_result');
        // Decode Base64
        $decoded = base64_decode($qrResult, true);
        list($id, $nama, $instansi) = explode('|', $decoded);
        $peserta = Peserta::find($id);
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

    public function inputIdDo(Request $request)
    {
        request()->validate([
            'id' => 'required|exists:tb_peserta,id',
        ]);
        $pesertas = Peserta::all();
        $peserta = Peserta::find($request->id);
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
            $request->session()->flash('message', 'Peserta ' . $nama . ' Berhasil Registrasi');
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
        $pesertas = Peserta::where(function ($query) use ($grup) {
            $query->where('id_grup', $grup->id)
                ->orWhereNull('id_grup');
        })->get();
        return view('admin.generate-grup', compact('grup', 'pesertas'));
    }

    public function grupGenerateDo(Request $request)
    {
        $grupId = $request->input('grup_id');
        $selectedUsers = $request->input('selected_users', []); // Ambil array ID peserta
        // dd($selectedUsers);
        $grup = Grup::findOrFail($grupId);

        // Hitung jumlah anggota sekarang
        $anggotaSekarang = Peserta::where('id_grup', $grupId)->count();

        // Hitung slot tersisa
        $sisaSlot = $grup->jumlah - $anggotaSekarang;

        // Validasi: jumlah yang dipilih tidak boleh melebihi slot tersisa
        if (count($selectedUsers) > $sisaSlot + $anggotaSekarang) {
            return redirect()->back()->withErrors(['msg' => 'Jumlah anggota melebihi kuota grup']);
        }

        // Reset semua peserta di grup ini yang tidak terpilih
        Peserta::where('id_grup', $grupId)
            ->whereNotIn('id', $selectedUsers)
            ->update(['id_grup' => null]);

        // Update semua peserta terpilih untuk masuk grup
        Peserta::whereIn('id', $selectedUsers)
            ->update(['id_grup' => $grupId]);

        return redirect()->route('admin.list.grup')->with('success', 'Anggota grup berhasil diupdate.');

        // $count = Peserta::where('id_grup', $request->id)->count();
        // $jumlahHadiah = Grup::find($request->id)->jumlah;

        // // Ngecek sisa
        // $sisa = $jumlahHadiah - $count;

        // if ($jumlahHadiah == $count && $sisa == 0) {
        //     return response()->json(['error' => 'Kuota hadiah sudah habis. Tidak dapat menambah anggota lagi.']);
        // } else {
        //     $pesertaAcak = Peserta::where('status', 2)
        //         ->whereNull('id_grup')->inRandomOrder()->limit($sisa)->get();
        //     return response()->json(['peserta' => $pesertaAcak]);
        // }
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
