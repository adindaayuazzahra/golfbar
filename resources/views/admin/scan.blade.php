@extends('layout.web')
@section('cssPage')
<style>
    #canvas {
        height: 100vh;
    }

    #preview video {
        transform: scaleX(-1);
    }
</style>
@endsection
@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center">
    <div class="card bg-transparent">
        <div id="preview" style="width:50vw"></div>
        <form id="form" action="{{route('admin.scan.do')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="npp" id="npp">
        </form>
        <!-- Button trigger modal -->
    </div>

    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#inputmanual">
        Input Manual
    </button>

</div>

{{-- Modal Konfirmasi --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="d-flex text-center flex-column justify-content-center mb-3">
                <p class="mb-0">Registrasi dengan NPP</p>
                <h4 id="confirmationNPP"></h4>
            </div>
            <div class="d-grid gap-2 d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Registrasi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Manual -->
<div class="modal fade" id="inputmanual" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-center mb-3">
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                <h5>Registrasi</h5>
            </div>
            <form method="POST" action="{{route('admin.scan.do')}}">
                {{ csrf_field() }}
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="npp" name="npp" required autocomplete="off">
                    <label for="floatingInput">NPP</label>
                </div>
                <div class="d-grid gap-2 d-flex justify-content-center">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Input</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('jsPage')
<script src="{{asset('js/html5-qrcode.min.js')}}"></script>
<script type="text/javascript">
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "preview", { fps: 10,  qrbox: { width: 350, height: 350 }},
       false
    );

    html5QrcodeScanner.render(onScanSuccess);

    function onScanSuccess(decodedText) {
        console.log(decodedText);
        // Tampilkan modal konfirmasi
        document.getElementById('confirmationNPP').textContent = decodedText;
        $('#confirmationModal').modal('show');
    }

    function submitForm() {
        // Submit formulir setelah konfirmasi
        document.getElementById('npp').value = document.getElementById('confirmationNPP').textContent;
        document.getElementById('form').submit();
    }
</script>

@if (session('message'))
<script>
    Swal.fire({
        timer: 5000,
        icon: '{{ session('icon') }}',
        title: '{{ session('title') }}',
        text: '{{ session('message') }}',
    });
</script>
@endif
@endsection