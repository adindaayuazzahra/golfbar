@extends('layout.web')
@section('cssPage')
<style>
    #canvas {
        height: 100vh;
    }

    .background-container {
        background-image: url('{{ asset("img/bgcerahf.png") }}');
        background-size: cover;
        background-position: center;
        /* height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        font-size: 24px; */
    }
</style>
@endsection
@section('content')
<!-- index.blade.php -->
<div
    class="container-fluid background-container d-flex flex-column h-100 align-items-center justify-content-between text-center">
    <div class="container-fluid p-0 mb-3 d-flex align-items-center justify-content-between">
        <div class="col d-flex justify-content-start">
            <img src="{{asset('img/logojm.png')}}" height="100px" alt="">
        </div>
        <div class="col d-flex justify-content-start">
            <img src="{{asset('img/judulgobar.png')}}" height="100px" alt="">
        </div>
        <div class="col d-flex justify-content-end">
            <img src="{{asset('img/logojmtm.png')}}" height="87px" alt="">
        </div>
        {{-- <img src="{{asset('img/gobarjudul.png')}}" alt=""> --}}
        {{-- <img src="{{asset('img/tanggal.png')}}" alt=""> --}}
    </div>
    <div class="row justify-content-start">
        @foreach($grups as $grup)
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">{{ $grup->nama_grup }}</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">
                        @foreach($grup->peserta as $peserta)
                        <li class="list-group-item label-1" style="font-size:14pt;">{{ $peserta->nama }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <p class="label-1 text-light fw-bold my-2 " style="font-size: 16pt;">System Powered By General Affair Section
        PT
        Jasamarga
        Tollroad Maintenance 2024
    </p>
</div>


{{--
<div
    class="container-fluid background-container d-flex flex-column h-100 bg-warning align-items-center justify-content-end text-center">
    <div class="container-fluid p-0 mb-3 d-flex align-items-center justify-content-between">
        <div class="col d-flex justify-content-start">
            <img src="{{asset('img/gobarjudul.png')}}" height="100px" alt="">
        </div>
        <div class="col d-flex justify-content-end">
            <img src="{{asset('img/tanggal.png')}}" height="60px" alt="">
        </div>
    </div>
    <div class="row d-flex align-items-center">
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Manggala Kusumo Wijayanto</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-1">
            <div class="card h-100" style="border-radius:20px;background-color:#277BC0; border: none;">
                <div class="card-body p-2">
                    <h4 class="card-title text-white header-1 mb-2">NAMA GRUP</h4>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">

                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                        <li class="list-group-item label-1" style="font-size:14pt;">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <p class="label-1 fw-bold my-2" style="font-size: 16pt;">System Powered By General Affair Section PT Jasamarga
        Tollroad Maintenance 2024
    </p>
</div> --}}

<script>
    setTimeout(() => {
        location.reload()
    }, 2000);
</script>

@endsection