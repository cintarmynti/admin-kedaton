@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Penghuni</h5>
            {{-- <p class="card-description">Pengguna yang telah ditambahkan akan muncul di halaman pengguna</p> --}}
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">NIK</label>
                            <input value="" type="number" required class="form-control" name="nik">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">Nama</label>
                            <input value="" type="text" required class="form-control" name="name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">No. Telp</label>
                            <input value="" type="text" required class="form-control" name="phone">
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">Password</label>
                            <input value="" type="password" required class="form-control" name="password">
                        </div>
                    </div> --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="form-label">Alamat</label>
                            <textarea rows="5" required class="form-control" name="alamat"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label ">Foto Pengguna</label>
                        <input value="" type="file" id="" required class="form-control" name="photo_identitas"
                            aria-label="First name">
                        <img id="output" class="mt-3" style="max-height: 200px; max-width: 300px">
                    </div>

                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label ">Foto KTP</label>
                        <input value="" type="file" id="filePhoto2" required class="form-control" name="photo_ktp"
                            aria-label="First name">
                        <img id="output2" class="mt-3" style="max-height: 200px; max-width: 300px">
                    </div>
                    <div class="col-md-12 mt-3 mb-2">
                        <hr>
                        <h5>Tambahkan Properti</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Pilih Cluster</label>
                                    <select class="form-select cluster" id="cluster_id">
                                        <option value="">Pilih Cluster</option>
                                        @foreach ($cluster as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                                    <select class="form-select" name="properti_id" id="no_rmh">
                                        <option value="" selected disabled>Pilih No Rumah</option>
                                    </select>

                                    <div id="kosong">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="formGroupExampleInput" class="form-label">RT</label>
                                <input value="{{ old('RT') }}" type="number" required class="form-control" id="RT"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="formGroupExampleInput" class="form-label">RW</label>
                                <input value="{{ old('RW') }}" type="number" required class="form-control" id="RW"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formGroupExampleInput" class="form-label">Alamat</label>
                                    <input rows="5" type="text" required class="form-control" id="alamat" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <br>
                                    <button onclick="tambahRumah()" class="btn btn-success mt-2" type="button"><i
                                            class="glyphicon glyphicon-remove"></i>
                                        Tambah</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-stripped">
                                    <thead>
                                        <th>Cluster</th>
                                        <th>No. Rumah</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Alamat</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="data-detail">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('properti') }}" class="btn btn-warning mt-4">kembali</a>
                        <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</button>
                    </div>
                </div>
                {{-- <div class="card-body">


                    <div class="row control-group">
                        <div class="col">
                            <label for="">Pilih Cluster</label>
                            <select class="form-select cluster" name="cluster_id">
                                <option hidden>Pilih Cluster</option>
                                @foreach ($cluster as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                            <select class="form-select" name="properti_id" id="no_rmh">
                                <option value="" selected disabled>Pilih No Rumah</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for=""></label>
                            <br>
                            <button onclick="tambahRumah()" class="btn btn-success mt-2" type="button"><i
                                    class="glyphicon glyphicon-remove"></i>
                                Tambah</button>
                        </div>
                    </div>



                    <div id="data-detail">

                    </div>
                    <a href="{{ route('properti') }}" class="btn btn-warning mt-4">kembali</a>
                    <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</button>
                </div> --}}

            </form>

        </div>
    </div>
@endsection

@push('after-script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#filePhoto").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output").attr("src", x);
                console.log(event);
            });

        });

        var inc = 0;

        function tambahRumah() {
            var id = $("#no_rmh").val();
            var nomer = $("#no_rmh option:selected").text();
            var cluster = $("#cluster_id option:selected").text();
            var rt = $('#RT').val();
            var rw = $('#RW').val();
            var alamat = $('#alamat').val();

            var html =
                `<tr id="row${inc}">
                    <input type="hidden" name="properti_id[]" value="${id}">
                    <td>${cluster}</td>
                    <td>${nomer}</td>
                    <td>${rt}</td>
                    <td>${rw}</td>
                    <td>${alamat}</td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteRumah(${inc})">Hapus</button>
                    </td>
                </tr>
                `;

            $('#data-detail').append(html);

            $('#RT').val('');
            $('#RW').val('');
            $('#alamat').val('');

        }

        function deleteRumah(id) {
            $("#row" + id).remove()
        }

        $(document).ready(function() {
            $(".btn-success").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });
        });

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.cluster').on('change', function() {
                var clusterID = $(this).val();
                if (clusterID) {
                    $.ajax({
                        url: '/user/nomer/' + clusterID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            // console.log(Number.isInteger(954));

                            console.log(data);
                                $('#no_rmh').html(data.opsi);
                                $('#no_rmh').trigger('change');
                                $('#kosong').html(data.html);
                        }
                    });
                } else {
                    $('#no_rmh').empty();
                }
            });

            $('#no_rmh').on('change', function() {
                var no_rmh = $(this).val();
                if (no_rmh) {
                    $.ajax({
                        url: '/properti-detail-json/' + no_rmh,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('#RT').val(data.properti.RT);
                            $('#RW').val(data.properti.RW);
                            $('#alamat').val(data.properti.alamat);
                        }
                    });
                } else {
                    $('#no_rmh').empty();
                }
            });
        });
    </script>
@endpush

@push('before-style')
    <style>
        .form-label {
            font-weight: 500;
        }

    </style>
@endpush
