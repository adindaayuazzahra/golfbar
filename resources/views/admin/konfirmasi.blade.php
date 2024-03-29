@extends('layout.web')

@section('cssPage')
<style>
    #canvas {
        height: 100vh;
    }
</style>
@endsection
{{-- @section('navbar')
@include('partials.navbar')
@endsection --}}

@section('content')
<div class="container p-0 d-flex  align-items-center justify-content-center">
    <div class="card my-4 mx-4 my-md-5 shadow shadow-md-lg" style="border-radius: 20px;border:none;">
        <img class="card-img-top img-cover" src="{{asset('img/header3.png')}}"
            style="max-height: 350px;border-radius: 20px 20px 0 0">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <h4 class="text-center">Terima Kasih</h4>
            <p class="text-center">Anda Sudah Berhasil Mengisi Form Konfirmasi Kehadiran. <br>Untuk info lebih lanjut
                akan di hubungi melalui Whatsapp oleh panitia.</p>
            <p class="mt-3 text-center"><span class="fw-bold">Contact Person</span> : 085215609439 <span
                    class="fw-bold">(ARI
                    SETYAWAN)</span></p>
        </div>
    </div>
</div>

{{-- <div class="container">
    <div class="card">
        <div class="card-body">
            <h6>Terima Kasih Anda Sudah Berhasil Mengisi Form Konfirmasi Kehadiran!</h6>
            <p>Untuk info lebih lanjut akan di hubungi melalui Whatssapp.</p>
        </div>
    </div>
</div> --}}
@endsection