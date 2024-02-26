@extends('layout.web')

{{-- @section('navbar')
@include('partials.navbar')
@endsection --}}

@section('content')
<div class="container p-0 d-flex  align-items-center justify-content-center">
    <div class="card my-4 mx-4 my-md-5 shadow shadow-md-lg" style="border-radius: 20px;border:none;">
        <img class="card-img-top img-cover" src="{{asset('img/header3.png')}}"
            style="max-height: 350px;border-radius: 20px 20px 0 0 ">
        <div class="col mt-3 px-2">
            <h1 class="text-center header-1 display-3"
                style="border-bottom:10px solid #F1C376; border-top:10px solid #F1C376;">
                RSVP
            </h1>
            <h1 class="text-center header-1 hijau display-4">GOBAR JASA MARGA</h1>
        </div>
        <div class="card-body ">

            <form action="{{route('register.do')}}" class="m-2 m-md-4" method="POST">
                {{ csrf_field() }}
                {{-- <div class="mb-4 position-relative">

                    <label style="font-size:14pt;" for="npp" class="form-label label-1 mb-1">NPP <span
                            class="text-danger">*</span></label>
                    <input autocomplete="off" type="text" class="form-control @error('npp') is-invalid @enderror"
                        name="npp" id="npp" value="{{old('npp')}}">
                    @error('npp')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div> --}}
                <div class="mb-4 position-relative">
                    <p class="mb-3"><span class="fw-bold"><span class="text-danger">*</span>Contact Person</span> :
                        085215609439 <span class="fw-bold">(ARI
                            SETYAWAN)</span></p>
                    <label style="font-size:14pt;" for="nama" class="form-label label-1 mb-1">Nama Lengkap <span
                            class="text-danger">*</span></label>
                    <input autocomplete="off" type="text" class="form-control @error('nama') is-invalid @enderror"
                        name="nama" id="nama" value="{{old('nama')}}">
                    @error('nama')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-4 position-relative">
                    <label style="font-size:14pt;" for="instansi" class="form-label label-1 mb-1">Unit Kerja<span
                            class="text-danger">*</span></label>
                    <input autocomplete="off" type="text" class="form-control @error('instansi') is-invalid @enderror"
                        name="instansi" id="instansi" value="{{old('instansi')}}">
                    @error('instansi')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-4 position-relative">
                    <label style="font-size:14pt;" for="whatsapp" class="form-label label-1 mb-1">No. Whatsapp<span
                            class="text-danger">*</span></label>
                    <p class="fw-light fst-italic lh-sm">(*) Format Nomor : 08XXXXXXX</p>
                    <input autocomplete="off" type="number" class="form-control @error('whatsapp') is-invalid @enderror"
                        name="whatsapp" id="whatsapp" value="{{old('whatsapp')}}">
                    @error('whatsapp')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-4 position-relative">
                    <label style="font-size:14pt;" for="ukuran_baju" class="form-label label-1 mb-2">Ukuran Baju<span
                            class="text-danger">*</span></label>
                    <select class="form-select @error('ukuran_baju') is-invalid @enderror" id="ukuran_baju"
                        name="ukuran_baju">
                        <option selected>Pilih Ukuran Baju</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                    @error('ukuran_baju')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-4 position-relative">
                    <label style="font-size:14pt;" for="status" class="form-label label-1 mb-2">Apakah anda
                        bersedia
                        untuk hadir ?<span class="text-danger">*</span></label><br>

                    <input type="radio" class="btn-check @error('status') is-invalid @enderror" name="status" value="y"
                        id="hadir" autocomplete="off" checked>
                    <label class="btn btn-outline-success rounded-pill me-1 mb-1" style="font-weight: bold"
                        for="hadir">Hadir</label>

                    <input type="radio" class="btn-check rounded @error('status') is-invalid @enderror" name="status"
                        value="n" id="tidak" autocomplete="off">
                    <label class="btn btn-outline-danger rounded-pill mb-1" style="font-weight: bold" for="tidak">Tidak
                        Hadir</label>

                    @error('status')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary mt-3 rounded-pill">KIRIM</button>
                    {{-- <a href="{{route('index')}}" class="btn btn-dark">Kembali</a> --}}
                </div>
            </form>
            <p class="mt-1 text-center">© 2024 IT & GA PT JASAMARGA TOLLROAD MAINTENANCE</p>
        </div>
    </div>
</div>
@endsection
@section('jsPage')
@if (session('message'))
<script>
    Swal.fire({
        timer: 2000,
        icon: '{{ session('icon') }}',
        title: '{{ session('title') }}',
        text: '{{ session('message') }}',
    });
</script>
@endif
@endsection