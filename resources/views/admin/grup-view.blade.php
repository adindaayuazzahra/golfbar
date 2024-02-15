@extends('layout.web')
@section('cssPage')
<style>
    #canvas {
        height: 100vh;
    }
</style>
@endsection
@section('content')
<!-- index.blade.php -->
<div class="container-fluid text-center">
    <div class="row justify-content-start">
        @foreach($grups as $grup)
        <div class="col-md-3 mb-3">
            <div class="card shadow-lg h-100" style="border-radius:20px;background-color:#277BC0">
                <div class="card-body p-2">
                    <h3 class="card-title text-white header-1 mb-2">{{ $grup->nama_grup }}</h3>
                    <ul class="list-group list-group-flush h-100" style="border-radius:20px;">
                        @foreach($grup->peserta as $peserta)
                        <li class="list-group-item label-1 py-1">{{ $peserta->nama }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection