@extends('layout.web')
@section('cssPage')
    <style>
        /* .background-container {
                        background-image: url('{{ asset('img/bgcerahf.png') }}');
                        background-size: cover;
                        background-position: center;
                    } */

        #canvas {
            height: 100vh;
        }

        #confetti {
            position: absolute;
            top: 0;
            left: 0;
            /* z-index: 1; */
        }

        .glass {
            /* From https://css.glass */
            background: rgba(255, 255, 255, 0.44);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glassAbu {
            /* From https://css.glass */
            background: rgba(95, 86, 86, 0.44);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(95, 86, 86, 0.3);
        }

        .glassKuning {
            /* From https://css.glass */
            background: rgba(23, 147, 223, 0.44);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(223, 190, 23, 0.3);
        }
    </style>
@endsection

@section('content')
    <!-- gagal input-->
    <canvas id="confetti"></canvas>
    {{-- <div class="modal fade dialogbox" id="rollingDoor" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
                <div id="closekocok" style="text-align: right;margin: 5px;">
                    <ion-icon name="close-outline" data-dismiss="modal"></ion-icon>
                </div>
                <div class="modal-body" style="font-size: 12px;" id="">
                    <div style="text-align: center;margin-top: 10%;margin-bottom: 5%;" class="">
                        <img src="https://eber.co/wp-content/uploads/2020/05/ezgif.com-crop.gif" alt="image"
                            class="" style="width: 450px;">
                    </div>
                    <hr>
                    <center>
                        <h1 class="bounce">Rolling Prize</h1>
                        <p
                            style="font-weight: 900;
                  font-size: 10px;
                  margin-top: 23px;
                  margin-bottom: 5px;">
                            Siapa pemenangnya..</p>
                    </center>
                </div>
                <div class="modal-footer" style="background-color: rgb(128, 0, 0);" id="">
                    <div class="btn-inline">
                        <!-- <a class="btn" id="readytoroll" style="font-weight: 900;color: white;">ROLL</a> -->
                        <a class="btn" style="font-weight: 900;color: white;" data-dismiss="modal">
                            <ion-icon name="close-circle-outline"></ion-icon> Tutup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- * end gagal input -->
    {{-- <div class="container-fluid background-container"> --}}
    <div class="row h-100 w-100  justify-content-center align-items-center ">
        <div class="row">
            <div class="col-md-6 ustify-content-end align-items-center d-flex">
                <img src="{{ asset('img/logojmtm.png') }}" height="68" alt="">
            </div>
            <div class="col-md-6 justify-content-end align-items-center d-flex">
                <img src="{{ asset('img/logojm.png') }}" height="68" alt="">
            </div>
        </div>
        {{-- <div style="background-color: #e8b920;" class="container rounded-pill p-2 mb-3 glass ">
            <h1 class="text-center fw-bold sample goyang"><img class="me-2" src="{{ asset('img/confetti.png') }}"
                    height="40px">
                DOORPRIZE <img class="ms-2" src="{{ asset('img/confetti.png') }}" height="40px"
                    style="transform: scaleX(-1);"></h1>
        </div> --}}
        <div class="row g-2 justify-content-center align-items-center">
            <div class="col-md-3">
                {{-- <div class="card shadow-lg glassKuning" style="border-radius:20px;height:700px;">
                    <div class="card-body">
                        <div class="card-content text-center px-2 py-2">
                            <div class="row ">
                                <select tabindex="0" class="form-select font-weight-bold rounded-5 border- "
                                    style="font-size: 18pt" id="hadiahDropdown" name="hadiahDropdown">
                                    <option value="">Pilih Hadiah</option>
                                    @foreach ($hadiahs as $h)
                                        <option value="{{ $h->id }}">{{ $h->nama_hadiah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="rowh-100">
                                <div class="text-center " id="gambarHadiah">
                                </div>
                                <div class="mt-25 text-center " id="namaHadiah">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card shadow-lg glassKuning" style="border-radius:20px; height:700px;">
                    <div class="card-body d-flex flex-column">

                        <!-- Select di atas -->
                        <div class="mb-4">
                            <select tabindex="0" class="form-select font-weight-bold rounded-5 border-0"
                                style="font-size: 18pt" id="hadiahDropdown" name="hadiahDropdown">
                                <option value="">Pilih Hadiah</option>
                                @foreach ($hadiahs as $h)
                                    <option value="{{ $h->id }}">{{ $h->nama_hadiah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Konten di tengah -->
                        <div class="flex-fill d-flex flex-column justify-content-center align-items-center text-center">
                            <div id="gambarHadiah"></div>
                            <div class="mt-5" id="namaHadiah"></div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col">
                <div class="card shadow-lg" style="border-radius:20px;height:700px;background-color:#277BC0">
                    <div class="card-body">
                        <div class="row p-0 h-100  d-flex justify-content-center align-items-center" id="pemenangArea">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    <audio id="mySound" src="{{ asset('sound/congrats.mp3') }}"></audio>
    {{-- <audio src="{{ asset('sound/rolling.mp3') }}" style="display: none;" id="rolls" type="audio/mpeg"></audio>
    <audio src="{{ asset('sound/congrats.mp3') }}" style="display: none;" id="cong" type="audio/mpeg"></audio> --}}
@endsection

@section('jsPage')
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.11.0/tsparticles.confetti.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hadiahDropdown').on('change', function() {
                $(this).blur();
            });

            $('#hadiahDropdown').change(function() {
                var selectedOption = $(this).find('option:selected');
                var namaHadiah = selectedOption.text();
                var id_hadiah = selectedOption.val();
                $('#namaHadiah').html('<h4>' + namaHadiah + '</h4>');
                // $('#nilaiPilihan').text(namaHadiah);
                if (id_hadiah) {
                    $('#pemenangArea').empty();
                    $.ajax({
                        url: '/get/foto/hadiah/' + id_hadiah,
                        type: 'GET',
                        success: function(response) {
                            if (response.foto) {
                                var fotoUrl = response.foto;
                                $('#gambarHadiah').html('<img  src="' + fotoUrl +
                                    '" width="250px" alt="Foto Hadiah">');
                                // $('#gambarHadiah').html('<img src="{{ Storage::url('public/hadiah/' . ' + fotoUrl + ') }}" alt="Foto Hadiah">');
                            } else {
                                $('#gambarHadiah').html('Foto tidak tersedia.');
                            }
                        }
                    });
                } else {
                    $('#gambarHadiah').empty();
                    $('#pemenangArea').empty();
                    $('#namaHadiah').empty();
                }
            });

            // Function to shuffle array
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            let isAnimating = false;
            let interval;

            // Event listener for spacebar key press
            $(document).on('keypress', function(e) {
                if (e.which == 32) { // Spacebar key code is 32
                    e.preventDefault(); // Prevent the default action (scrolling)
                    if (!isAnimating) {
                        startAnimation();
                    } else {
                        stopAnimation();
                    }
                }
                if (e.which == 114) { // 'R' key code is 82 for uppercase and 114 for lowercase
                    e.preventDefault(); // Prevent the default action (scrolling)
                    if (!isAnimating) {
                        startResetAnimation();
                    } else {
                        stopAnimation();
                    }
                }
            });



            function startResetAnimation() {
                var selectedHadiahId = $('#hadiahDropdown').val();

                if (selectedHadiahId == '' || !selectedHadiahId) {
                    alert('Pilih hadiah terlebih dahulu!');
                    return;
                }

                isAnimating = true;

                // Ambil data pemenang
                $.ajax({
                    url: '/get-reset/' + selectedHadiahId,
                    method: 'GET',
                    success: function(response) {
                        var pemenangList = response;
                        console.log(pemenangList);
                        // Ambil semua peserta untuk animasi acak
                        $.ajax({
                            url: '/get-pemenang/' + selectedHadiahId,
                            method: 'GET',
                            success: function(response) {
                                var pemenangList = response;

                                // Ambil semua peserta untuk animasi acak
                                $.ajax({
                                    url: '{{ route('getAllPeserta') }}',
                                    method: 'GET',
                                    success: function(allPeserta) {
                                        console.log('allPeserta', allPeserta);

                                        interval = setInterval(function() {
                                            var shuffledPeserta =
                                                shuffleArray(
                                                    allPeserta);
                                            $('#pemenangArea').empty();
                                            for (var i = 0; i < Math
                                                .min(pemenangList
                                                    .length, 20); i++) {
                                                if (i < shuffledPeserta
                                                    .length) {
                                                    $('#pemenangArea')
                                                        .append(
                                                            '<div class="col-3 col-md-3 active"><div class="p-3 rounded-10 bg-light text-center"><h5>' +
                                                            shuffledPeserta[
                                                                i]
                                                            .nama +
                                                            '</h5></div></div>'
                                                        );
                                                }
                                            }
                                        }, 50); // Change names every 50ms
                                    }
                                });
                            }
                        });
                    }
                });

            }


            function startAnimation() {
                var selectedHadiahId = $('#hadiahDropdown').val();

                if (selectedHadiahId == '' || !selectedHadiahId) {
                    alert('Pilih hadiah terlebih dahulu!');
                    return;
                }

                isAnimating = true;

                // Ambil data pemenang
                $.ajax({
                    url: '/get-pemenang/' + selectedHadiahId,
                    method: 'GET',
                    success: function(response) {
                        var pemenangList = response;

                        // Ambil semua peserta untuk animasi acak
                        $.ajax({
                            url: '{{ route('getAllPeserta') }}',
                            method: 'GET',
                            success: function(allPeserta) {
                                interval = setInterval(function() {
                                    console.log('allPeserta', allPeserta);

                                    var shuffledPeserta = shuffleArray(allPeserta);
                                    $('#pemenangArea').empty();
                                    for (var i = 0; i < Math.min(pemenangList
                                            .length, 20); i++) {
                                        if (i < shuffledPeserta.length) {
                                            $('#pemenangArea').append(
                                                '<div class="col-3 col-md-3 active"><div class="p-3 rounded-10 bg-light text-center"><h5>' +
                                                shuffledPeserta[i].nama +
                                                '</h5></div></div>'
                                            );
                                        }
                                    }
                                }, 50); // Change names every 50ms
                            }
                        });
                    }
                });
            }

            function stopAnimation() {
                clearInterval(interval);
                isAnimating = false;
                var selectedHadiahId = $('#hadiahDropdown').val();

                // Ambil data pemenang
                $.ajax({
                    url: '/get-pemenang/' + selectedHadiahId,
                    method: 'GET',
                    success: function(response) {
                        var pemenangList = response;
                        $('#pemenangArea').empty();
                        for (var i = 0; i < Math.min(pemenangList.length, 20); i++) {
                            $('#pemenangArea').append(
                                '<div class="col-3 col-md-3 active"><div class="p-3 rounded-10 bg-light text-center"><h5>' +
                                pemenangList[i].nama + '</h5></div></div>'
                            );
                        }
                        $("#mySound")[0].play();

                        const count = 2000,
                            defaults = {
                                origin: {
                                    y: 0.9
                                },
                            };

                        function fire(particleRatio, opts) {
                            confetti(
                                Object.assign({}, defaults, opts, {
                                    particleCount: Math.floor(count * particleRatio),
                                })
                            );
                        }

                        fire(0.25, {
                            spread: 26,
                            startVelocity: 55,
                        });

                        fire(0.2, {
                            spread: 60,
                        });

                        fire(0.35, {
                            spread: 100,
                            decay: 0.91,
                            scalar: 0.8,
                        });

                        fire(0.1, {
                            spread: 120,
                            startVelocity: 25,
                            decay: 0.92,
                            scalar: 1.2,
                        });

                        fire(0.1, {
                            spread: 120,
                            startVelocity: 45,
                        });

                    }
                });
            }

        });
    </script>
@endsection
