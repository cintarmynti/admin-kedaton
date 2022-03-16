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
                        <input value="" type="number" id="nik" maxlength="16" required class="form-control" name="nik">
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
                    <input value="" type="file" id="" required class="form-control" name="photo_identitas" aria-label="First name">
                    <img id="output" class="mt-3" style="max-height: 200px; max-width: 300px">
                </div>

                <div class="col-md-4">
                    <label for="formGroupExampleInput" class="form-label ">Foto KTP</label>
                    <input value="" type="file" id="filePhoto2" required class="form-control" name="photo_ktp" aria-label="First name">
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
                                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert" id="alert_rumah">
                                    <strong>Tidak ada properti tersedia, mohon tambahkan terlebih dahulu <a href="/properti/create">disini</a>.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div id="kosong">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="formGroupExampleInput" class="form-label">RT</label>
                            <input value="{{ old('RT') }}" type="number" required class="form-control" id="RT" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="formGroupExampleInput" class="form-label">RW</label>
                            <input value="{{ old('RW') }}" type="number" required class="form-control" id="RW" readonly>
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
                                <button onclick="tambahRumah()" class="btn btn-success mt-2" type="button"><i class="glyphicon glyphicon-remove"></i>
                                    Tambah</button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <hr>
                            <h5>List Properti yang sudah ditambahkan</h5>
                        </div>
                        <div class="col-md-12 mt-3">
                            <table class="table table-stripped">
                                <thead>
                                    <th>No.</th>
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
                    {{-- <div class="col-md-12">
                        <a href="{{ route('properti') }}" class="btn btn-warning mt-4">kembali</a>
                        <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</button>
                    </div> --}}
                </div>
                <div class="col-md-12">
                    <a href="{{ route('user') }}" class="btn btn-warning mt-4">kembali</a>
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
        <button onclick="tambahRumah()" class="btn btn-success mt-2" type="button"><i class="glyphicon glyphicon-remove"></i>
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


        $('#nik').on('keyup', function() {
            limitText(this, 16)
        });

        function limitText(field, maxChar){
            var ref = $(field),
                val = ref.val();
            if ( val.length >= maxChar ){
                ref.val(function() {
                    console.log(val.substr(0, maxChar))
                    return val.substr(0, maxChar);
                });
            }
        }


    $( document ).ready(function() {
        $("#nik").attr('maxlength',maxChar);
    });


    $(function() {
        $("#filePhoto").change(function(event) {
            var x = URL.createObjectURL(event.target.files[0]);
            $("#output").attr("src", x);
            console.log(event);
        });

    });

    var inc = 1;
    var array_rumah = [];


    function tambahRumah() {
        var id = $("#no_rmh").val();
        var nomer = $("#no_rmh option:selected").text();
        var cluster = $("#cluster_id option:selected").text();
        var rt = $('#RT').val();
        var rw = $('#RW').val();
        var alamat = $('#alamat').val();


        var names = cluster + id;
        // var names2 = 'dekat1';
        var cek = jQuery.inArray(names, array_rumah);
        // var cek = jQuery.inArray('dekat1', array_rumah);
        // alert(cek);
        if (cek == -1) {
            var row = $("#data-detail tr").length;
            var html =
                `<tr id="${cluster+id}">
                    <input type="hidden" name="properti_id[]" value="${id}">
                    <td id="numberRow${row + 1}">${row + 1}</td>
                    <td>${cluster}</td>
                    <td>${nomer}</td>
                    <td>${rt}</td>
                    <td>${rw}</td>
                    <td>${alamat}</td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteRumah('${cluster+id}')">Hapus</button>
                    </td>
                </tr>
                `;
            $('#data-detail').append(html);
            $('#RT').val('');
            $('#RW').val('');
            $('#alamat').val('');
            array_rumah.push(cluster + id);
        } else {
            alert('rumah sudah ditambahkan');
            return false;
        }
        // alert( names2);

    }

    function deleteRumah(id) {
        var row = $("#data-detail tr").length;
        // alert(id);
        array_rumah = $.grep(array_rumah, function(value) {
            return value !== id;
        });
        // return array_rumah;
        // alert(array_rumah);
        $('#' + id).remove();
        $('#numberRow' + row).text(row - 1);


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

    $(document).ready(function() {
        $('#alert_rumah').hide();
    });

    $('.cluster').on('change', function() {
        $('#no_rmh').html('');
        $('#RT').val('');
        $('#RW').val('');
        $('#alamat').val('');
        var clusterID = $(this).val();
        var cluster_name = $(this).find('option:selected').text();
        if (clusterID) {
            $.ajax({
                url: '/user/nomer/' + clusterID,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        var data = response.data;
                        var options = '';
                        options += '<option value="">Pilih No Rumah</option>';
                        for (var i = 0; i < data.length; i++) {
                            // console.log("'" + cluster_name + data[i].id +"'");
                            // console.log("'" + cluster_name + array_rumah +"'");
                            // alert(cekArrayRumah("'" + cluster_name + data[i].id +"'","'" + cluster_name + array_rumah +"'"));
                            options += '<option value="' + data[i].id + '">' + data[i].no_rumah + '</option>';
                        };
                        $('#no_rmh').html(options);
                        $('#alert_rumah').hide();
                    } else {
                        $('#no_rmh').html('');
                        $('#alert_rumah').show();
                    }

                    // $('#no_rmh').trigger('change');

                    // if (data.opsi == '') {
                    //     $('#alert_rumah').show();
                    // } else {
                    //     $('#alert_rumah').hide();
                    //     $('#no_rmh').html(data.opsi);
                    //     // $('#no_rmh').trigger('change');
                    // }


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

                    if (data.properti) {
                        $('#RT').val(data.properti.RT);
                        $('#RW').val(data.properti.RW);
                        $('#alamat').val(data.properti.alamat);
                    }
                    // $('#RT').val();
                    // $('#RW').val();
                    // $('#alamat').val();

                }
            });
        } else {
            $('#no_rmh').empty();
        }
    });
</script>

<script>

</script>
@endpush

@push('before-style')
<style>
    .form-label {
        font-weight: 500;
    }
</style>
@endpush
