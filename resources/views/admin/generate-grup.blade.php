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
                <div class="row d-flex justify-content-between align-items-center mb-3">
                    <h5><strong>{{ $grup->nama_grup }} ({{ $grup->jumlah }} Anggota)</strong></h5>
                    <form id="formAddUsers" method="POST" action="{{ route('admin.grup.generate.do') }}">
                        {{-- <form id="formAddUsers" method="POST" action="{{ route('admin.grup.generate.do', ['id' => $grup->id]) }}"> --}}
                        @csrf
                        <input type="hidden" id="grup_id" name="grup_id" value="{{ $grup->id }}">
                        <table id="pesertaTable" class="table">
                            <thead>
                                <tr>
                                    <th># ID</th>
                                    <th>Name Apps</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesertas as $a)
                                    <tr>
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->nama }}</td>
                                        <td>
                                            <input type="checkbox" name="selected_users[]" value="{{ $a->id }}"
                                                {{ $a->id_grup && $a->id_grup == $grup->id ? 'checked' : '' }}
                                                class="user-checkbox">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                            <a href="{{ route('admin.list.grup') }}" class="btn btn-secondary" style="border-radius: 5px;">
                                <i class="fa-solid fa-arrow-left-long"></i>
                            </a>
                            <button id="btn-generate" type="submit" class="btn btn-primary">
                                Generate
                            </button>
                        </div>
                    </form>
                </div>
                {{-- <div id="hasil-generate"></div> --}}
            </div>
        </div>
    </div>
@endsection
@section('jsPage')
    <script>
        $(document).ready(function() {

            let maxSelected = {{ $grup->jumlah }};
            let selectedUsers = [];

            // DataTable init
            let table = $('#pesertaTable').DataTable({
                paging: true,
                searching: true
            });

            // Ambil semua centangan awal
            table.rows().every(function() {
                let checkbox = $(this.node()).find('.user-checkbox');
                if (checkbox.prop('checked')) {
                    selectedUsers.push(checkbox.val());
                }
            });

            // Event saat checkbox diklik
            $(document).on('change', '.user-checkbox', function() {
                let val = $(this).val();
                if ($(this).prop('checked')) {
                    if (selectedUsers.length < maxSelected) {
                        if (!selectedUsers.includes(val)) selectedUsers.push(val);
                    } else {
                        $(this).prop('checked', false);
                        alert('Maksimal ' + maxSelected + ' anggota.');
                    }
                } else {
                    selectedUsers = selectedUsers.filter(id => id !== val);
                }
                updateCheckboxStates();
            });

            // Update status disable checkbox
            function updateCheckboxStates() {
                table.rows().every(function() {
                    let checkbox = $(this.node()).find('.user-checkbox');
                    if (selectedUsers.length >= maxSelected && !checkbox.prop('checked')) {
                        checkbox.prop('disabled', true);
                    } else {
                        checkbox.prop('disabled', false);
                    }
                });
            }

            // Restore centangan setelah redraw DataTable
            table.on('draw', function() {
                table.rows().every(function() {
                    let checkbox = $(this.node()).find('.user-checkbox');
                    checkbox.prop('checked', selectedUsers.includes(checkbox.val()));
                });
                updateCheckboxStates();
            });

            // Submit form kirim semua pilihan
            $('#formAddUsers').on('submit', function(e) {
                // Bersihkan hidden input lama
                $('#formAddUsers input[name="selected_users[]"]').remove();

                // Tambahkan hidden input untuk semua selectedUsers
                selectedUsers.forEach(function(id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'selected_users[]',
                        value: id
                    }).appendTo('#formAddUsers');
                });
            });

            // Init awal
            updateCheckboxStates();

            // var table = $('#pesertaTable').DataTable();

            // let maxSelected = {{ $grup->jumlah }}; // batas total grup
            // let selectedUsers = [];

            // // Ambil checkbox yang sudah tercentang dari awal
            // $('input[name="selected_users[]"]:checked').each(function() {
            //     selectedUsers.push($(this).val());
            // });

            // // Saat halaman load, kalau sudah penuh, disable sisanya
            // if (selectedUsers.length >= maxSelected) {
            //     $('input[name="selected_users[]"]').not(':checked').prop('disabled', true);
            // }

            // // Saat checkbox diklik
            // $(document).on('change', 'input[name="selected_users[]"]', function() {
            //     let val = $(this).val();

            //     if ($(this).prop('checked')) {
            //         if (selectedUsers.length < maxSelected) {
            //             selectedUsers.push(val);
            //         } else {
            //             // kalau penuh, batalkan centang
            //             $(this).prop('checked', false);
            //             alert('Maksimal ' + maxSelected + ' anggota untuk grup ini.');
            //         }
            //     } else {
            //         selectedUsers = selectedUsers.filter(v => v !== val);
            //     }

            //     // Set disabled kalau penuh
            //     if (selectedUsers.length >= maxSelected) {
            //         $('input[name="selected_users[]"]').not(':checked').prop('disabled', true);
            //     } else {
            //         $('input[name="selected_users[]"]').prop('disabled', false);
            //     }
            // });

            // Inject input sebelum submit form
            // $('#formAddUsers').on('submit', function() {
            //     $('#formAddUsers input[type="hidden"][name="selected_users[]"]').remove();
            //     selectedUsers.forEach(function(id) {
            //         $('<input>').attr({
            //             type: 'hidden',
            //             name: 'selected_users[]',
            //             value: id
            //         }).appendTo('#formAddUsers');
            //     });
            // });

        });
    </script>
@endsection
