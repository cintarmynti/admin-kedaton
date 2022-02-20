@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Penghuni</h5>
            {{-- <p class="card-description">Pengguna yang telah ditambahkan akan muncul di halaman pengguna</p> --}}
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Nama</label>
                        <input value="" type="text" required class="form-control" name="name" aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">NIK</label>
                        <input value="" type="number" required class="form-control" name="nik" aria-label="Last name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">No Telp</label>
                        <input value="" type="text" required class="form-control" name="phone" aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    {{-- <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Email</label>
                        <input value="" type="email" required class="form-control" name="email" aria-label="First name">
                    </div> --}}
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Password</label>
                        <input value="" type="password" required class="form-control" name="password"
                            aria-label="Last name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Alamat</label>
                        <input value="" type="text" required class="form-control" name="alamat" aria-label="First name">
                    </div>
                </div>

                <div class="row mt-4 mb-4">
                    {{-- <div class="col">
                    <label for="formGroupExampleInput" class="form-label ">Status Kepemilikan</label>
                    <select class="form-select" name="status_penghuni" aria-label="Default select example">
                        <option disabled="" selected="">Pilih Status Kepemilikan</option>
                        <option value="dihuni">pemilik</option>
                        <option value="disewakan">penghuni</option>
                    </select>
                </div> --}}

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


                </div>


                {{-- <a href="{{ route('user') }}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a> --}}


                {{-- </form> --}}



        </div>

        <div class="card-body">
            <h5 class="card-title">Tambahkan Properti</h5>

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
                        {{-- <label for=""></label> --}}
                        <br>
                        <button  onclick="tambahRumah()" class="btn btn-success mt-2" type="button"><i class="glyphicon glyphicon-remove"></i>
                            Tambah</button>
                    </div>



                </div>

            {{-- <input type="text" id="no_rumah" >
            <button onclick="tambahRumah()">Tambah</button> --}}

            <div id="data-detail">

            </div>
            <a href="{{ route('properti') }}" class="btn btn-warning mt-4">kembali</a>
            <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>

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
            var noRumah = $("#no_rmh").val();
            var html =
                ` <div class="row">
                    <div class="col">
                        <div id="row${inc}"><input class="form-control" type="text" value="${noRumah}">
                    </div>
                    <div class="col">
                        <button class="btn btn-danger" onclick="deleteRumah(${inc})">Hapus</button></div>
                    </div>
                </div>
                `;

            $('#data-detail').append(html);
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
                        dataType: "html",
                        success: function(data) {
                            $('#no_rmh').html(data);
                            $('#no_rmh').trigger('change');
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
