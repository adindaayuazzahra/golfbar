@extends('layout.web')
@section('cssPage')
    <style>
        #canvas {
            height: 100vh;
        }
    </style>
@endsection

@section('content')
    <div class="row-md-12">
        <div class="card shadow-lg" style="border-radius:20px;width:90vw;">
            <div class="card-body">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5><strong>Daftar Grup</strong></h5>
                        <div>
                            <a href="{{ route('admin.home') }}" class="btn btn-secondary" style="border-radius: 5px;">
                                <i class="fa-solid fa-arrow-left-long"></i>
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#grupAdd">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <table id="table_grup" class="table text-white">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Grup</th>
                                {{-- <th scope="col">Gambar</th> --}}
                                <th scope="col">Jumlah</th>
                                <th scope="col">sisa</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grups as $g)
                                <tr>
                                    <td>{{ $g->id }}</td>
                                    <td>{{ $g->nama_grup }}</td>
                                    <td>{{ $g->jumlah }}</td>
                                    <td>
                                        @if ($g->jumlah - $g->peserta->count())
                                            {{ $g->jumlah - $g->peserta->count() }}
                                        @else
                                            Habis
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#grupEdit{{ $g->id }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <a href="{{ route('admin.grup.delete', ['id' => $g->id]) }}"
                                            class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                                        <a href="{{ route('admin.grup.generate', ['id' => $g->id]) }}"
                                            class="btn btn-secondary"><i class="fa-solid fa-users"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->


    <!-- Modal Hadiah ADD -->
    <div class="modal fade text-dark" id="grupAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Tambah Grup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.grup.add') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_grup">Nama Grup</label>
                            <input type="text" class="form-control @error('nama_grup') is-invalid @enderror"
                                id="nama_grup" name="nama_grup">
                            @error('nama_grup')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                                name="jumlah">
                            @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hadiah EDIT -->
    @foreach ($grups as $g)
        <div class="modal fade text-dark" id="grupEdit{{ $g->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Edit Grup</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.grup.edit', ['id' => $g->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_grup_edit">Nama Grup</label>
                                <input type="text" class="form-control @error('nama_grup_edit') is-invalid @enderror"
                                    id="nama_grup_edit" name="nama_grup_edit" value="{{ $g->nama_grup }}">
                                @error('nama_grup_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jumlah_edit">Jumlah</label>
                                <input type="text" class="form-control @error('jumlah_edit') is-invalid @enderror"
                                    id="jumlah_edit" name="jumlah_edit" value="{{ $g->jumlah }}">
                                @error('jumlah_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('jsPage')
    {{-- @if ($errors->has('addHadiahErr'))
<script>
    $(document).ready(function() {
        $('#grupAdd').modal('show');
    });

</script>
@elseif ($errors->has('addHadiahErrEdit'))
<script>
    $(document).ready(function() {
        $('#grupEdit{{$g->id}}').modal('show');
    });

</script>
@endif --}}
    <script>
        $(document).ready(function() {
            $('#table_grup').DataTable({
                pageLength: 10, // Jumlah entri per halaman
                lengthMenu: [10, 15], // Opsi jumlah entri per halaman yang dapat dipilih
            });
        })
    </script>
@endsection
