@extends('layout.web')
@section('cssPage')
    <style>
        #canvas {
            height: 100vh;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-3" style="border-radius:20px;">
                    <div class="card-body">
                        <form class="d-flex" method="POST" action="{{ route('admin.scan.gun.do') }}">
                            @csrf
                            {{-- <div class=" mb-3"> --}}
                            <input type="text" class="form-control me-2" id="qr_result" name="qr_result" required
                                autocomplete="off">
                            {{-- <label for="floatingInput">Nama</label> --}}
                            <button type="submit" class="btn btn-primary">Input</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow mb-3" style="border-radius:20px;">
                    <div class="card-body">
                        <form class="d-flex needs-validation" method="POST" action="{{ route('admin.input.id.do') }}"
                            novalidate>
                            @csrf
                            <input type="text" class="form-control me-2" id="id" name="id" required
                                autocomplete="off" placeholder="Masukkan ID Peserta">
                            @error('id')
                                <div class="invalid-tooltip d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            <button type="submit" class="btn btn-primary">Input</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-lg" style="border-radius:20px;">
            <div class="card-body">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <h3><strong>List Peserta</strong></h3>
                        <div class="d-flex ">
                            <a href="{{ route('admin.home') }}" class="btn btn-secondary me-2" style="border-radius: 5px;">
                                <i class="fa-solid fa-arrow-left-long"></i>
                            </a>
                            <form action="{{ route('users.import') }}" class="d-flex" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" class="form-control me-2">

                                <button class="btn btn-success">IMPORT</button>
                            </form>
                        </div>
                    </div>

                    @if (session('message'))
                        <div class="alert alert-{{ session('icon') }}" role="alert">
                            <div>
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif

                    <table id="list" class="table text-white" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Instansi</th>
                                <th>Size</th>
                                <th>Whatsapp</th>
                                <th>Grup</th>
                                <th>Status</th>
                                <th>Hadiah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesertas as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->instansi }}</td>
                                    <td>{{ $p->ukuran_baju }}</td>
                                    <td>{{ $p->whatsapp }}</td>
                                    <td>
                                        @if ($p->id_grup == 0)
                                            -
                                        @else
                                            {{ $p->grup->nama_grup }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($p->status == 0)
                                            <div class="badge rounded-pill text-bg-danger">Tidak Hadir</div>
                                        @elseif($p->status == 1)
                                            <div class="badge rounded-pill text-bg-primary">Hadir</div>
                                        @elseif($p->status == 2)
                                            <div class="badge rounded-pill text-bg-success">Registrasi</div>
                                        @elseif($p->status == 3)
                                            <div class="badge rounded-pill text-bg-warning">Menang Doorprize</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($p->id_hadiah)
                                            {{ $p->hadiah->nama_hadiah }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#pesertaEdit{{ $p->id }}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button> --}}
                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-warning rounded-circle" data-bs-toggle="modal"
                                            data-bs-target="#qrModal{{ $p->id }}">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="qrModal{{ $p->id }}" tabindex="-1"
                                            aria-labelledby="qrModalLabel{{ $p->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content bg-dark text-white">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title" id="qrModalLabel{{ $p->id }}">QR
                                                            Code Peserta: {{ $p->nama }}</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ route('admin.download.qr', ['id' => $p->id]) }}"
                                                            alt="QR Code" class="img-fluid" style="max-width: 350px;">
                                                    </div>
                                                    <div class="modal-footer border-0 justify-content-center">
                                                        <a href="{{ route('admin.download.qr', ['id' => $p->id]) }}"
                                                            class="btn btn-primary" download>
                                                            <i class="fa-solid fa-download"></i> Download QR
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a href="{{route('admin.generate.qr', ['id' => $p->id])}}"
                                    class="btn btn-warning rounded-circle"><i class="fa-solid fa-qrcode"></i></a> --}}
                                        {{-- <a href="https://wa.me/{{$p->whatsapp}}" target="_blank">
                                    <i style="font-size: 18px; " class="fab fa-whatsapp" aria-hidden="true"></i>
                                    +62&nbsp;812-8866-8996 (Admin)
                                </a> --}}
                                        <a href="https://wa.me/62{{ $p->whatsapp }}" target="_blank"
                                            class="btn btn-success rounded-circle"><i class="fa-brands fa-whatsapp"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsPage')
    <script>
        $(document).ready(function() {
            $('#list').DataTable({
                responsive: true, // Opsi jumlah entri per halaman yang dapat dipilih
                pageLength: 6, // Jumlah entri per halaman
                lengthMenu: [6, 8, 10],
            });

            $('#nama').focus();

        })
    </script>

    {{-- @if (session('message'))
<script>
    Swal.fire({
        timer: 1000,
        icon: '{{ session('icon') }}',
        title: '{{ session('title') }}',
        text: '{{ session('message') }}',
    });
</script>
@endif --}}
@endsection
