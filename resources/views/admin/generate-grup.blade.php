@extends('layout.web')
@section('cssPage')
<style>
    #canvas {
        height: 100vh;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="card" style="width:80vw">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5><strong>{{$grup->nama_grup}} ({{ $grup->jumlah}} Anggota)</strong></h5>
                <div>
                    <a href="{{route('admin.list.grup')}}" class="btn btn-secondary" style="border-radius: 5px;">
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </a>
                    <button class="btn btn-warning" style="display: none;" id="btn-lock">Lock Pemenang</button>
                    <input type="hidden" id="grup" value="{{$grup->id}}">
                    <button id="btn-generate" type="button" class="btn btn-primary">
                        Generate
                    </button>
                </div>
            </div>
            <div id="hasil-generate"></div>
        </div>
    </div>
</div>
@endsection
@section('jsPage')
<script>
    $(document).ready(function() {

        // Meng-handle klik tombol generate
        $('#btn-generate').on('click', function() {
            var id = $('#grup').val();
            // Mengambil data pemenang sesuai hadiah
            $.ajax({
                url: "{{route('admin.grup.generate.do')}}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if (response.error) {
                        // Kuota sudah habis, tampilkan pesan kesalahan
                        alert(response.error);
                    } else {
                        // Pastikan respons memiliki kunci yang benar, sesuai dengan 'peserta'
                        var pesertaAcak = response.peserta;

                        // Menampilkan hasil generate
                        $('#hasil-generate').empty();

                        if (pesertaAcak.length > 0) {
                            // Buat tabel dan header
                            var table = $('<table>').addClass('table');
                            var thead = $('<thead>');
                            var tbody = $('<tbody>');

                            // Tambahkan header ke dalam thead
                            var headerRow = $('<tr>').append(
                                $('<th>').text('No'),
                                $('<th>').text('NPP'),
                                $('<th>').text('Nama Peserta')
                            );
                            thead.append(headerRow);

                            // Iterasi melalui pesertaAcak dan tambahkan baris ke dalam tbody
                            $.each(pesertaAcak, function(index, peserta) {
                                var row = $('<tr>').append(
                                    $('<td>').text(index + 1),
                                    $('<td>').text(peserta.npp),
                                    $('<td>').text(peserta.nama)
                                );
                                tbody.append(row);
                            });

                            // Tambahkan thead dan tbody ke dalam tabel
                            table.append(thead, tbody);

                            // Tampilkan tabel di dalam elemen 'hasil-generate'
                            $('#hasil-generate').append(table);
                        } else {
                            // Tampilkan pesan jika tidak ada pesertaAcak
                            $('#hasil-generate').append('<p>Semua Peserta Sudah Mendapat Grup</p>');
                        }
                    

                        // Menampilkan tombol lock
                        $('#btn-lock').show();
                    }

                },
                error: function(error) {
                    // Tangani kesalahan jika terjadi
                    alert('Terjadi kesalahan saat melakukan generate anggota group.');
                },
            });
        });

        $('#btn-lock').on('click', function() {
            var idGrup = $('#grup').val(); // Mengambil ID hadiah dari elemen dengan id 'hadiah'
            var anggotaData = []; // Menampung data peserta yang dihasilkan

            // Mengambil nama peserta dari hasil generate
            $('#hasil-generate tbody tr').each(function(index, row) {
                var nppPeserta = $(row).find('td:nth-child(2)').text().trim(); // Mengambil NPP peserta
                var namaPeserta = $(row).find('td:nth-child(3)').text().trim(); // Mengambil nama peserta

                // Menyimpan data peserta ke dalam array
                anggotaData.push({
                    npp: nppPeserta,
                    nama: namaPeserta
                });
            });

            // Mengirim data pemenang ke server untuk dilock
            $.ajax({
                url: "{{route('admin.grup.generate.lock')}}",
                type: 'POST',
                data: {
                    anggota: anggotaData,
                    id: idGrup,
                    _token: "{{ csrf_token() }}" // Jangan lupa sertakan token CSRF jika diperlukan
                },
                success: function(response) {
                    // Menampilkan pesan sukses atau melakukan tindakan lainnya
                    alert(response.message);
                },
                error: function(error) {
                    // Tangani kesalahan jika terjadi
                    // var errorMessage = xhr.responseText;
                    alert('Terjadi kesalahan saat melakukan locking Anggota');
                }
            });
        });


    });
</script>
@endsection