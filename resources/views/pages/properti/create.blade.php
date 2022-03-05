@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Properti</h5>
            {{-- <p class="card-description">Listing yang telah ditambahkan akan muncul di halaman listing</p> --}}
            <form action="{{ route('properti.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Pilih Cluster</label>

                        <select id="category" class="form-control select2" name="cluster_id"
                            aria-label="Default select example">
                            <option disabled selected="">Pilih Cluster</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">No Rumah</label>
                            <input value="{{ old('no') }}" type="text" required class="form-control" name="no">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">RT</label>
                        <input value="{{ old('RT') }}" type="number" required class="form-control" name="RT">
                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">RW</label>
                        <input value="{{ old('RW') }}" type="number" required class="form-control" name="RW">
                    </div>

                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Provinsi</label>
                        <select onchange="getKota(this.value)" id="select_prov" class="form-select" name="provinsi_id" aria-label="Default select example">
                            {{-- <option disabled selected="">Provinsi</option> --}}
                        </select>
                        <input type="hidden" name="provinsi" id="name_prov">

                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Kabupaten/Kota</label>
                        <select onchange="getKecamatan(this.value)" id="select_kota" class="form-select" name="kabupaten_id" aria-label="Default select example">
                            {{-- <option disabled selected="">Kabupaten</option> --}}
                        </select>
                        <input type="hidden" name="kabupaten" id="name_kota">


                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Kecamatan</label>
                        <select onchange="getKelurahan(this.value)"  id="select_kec" class="form-select" name="kecamatan_id" aria-label="Default select example">
                            <option disabled selected="">Kecamatan</option>
                        </select>
                        <input type="hidden" name="kecamatan" id="name_kec">


                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Kelurahan</label>
                        <select id="select_kel" class="form-select" name="kelurahan_id"  aria-label="Default select example">
                            <option disabled selected="">Kelurahan</option>
                        </select>
                        <input type="hidden" name="kelurahan" id="name_kel">

                    </div>
                    <div class="col-md-12"></div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Alamat</label>
                            <textarea rows="5" type="text" required class="form-control" name="alamat"></textarea>
                        </div>
                    </div>




                    <div class="col-md-12"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Jumlah Lantai</label>
                            <input value="{{ old('lantai') }}" type="number" required class="form-control"
                                name="lantai">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Jumlah Kamar</label>
                            <input value="{{ old('jumlah_kamar') }}" type="number" required class="form-control"
                                name="jumlah_kamar">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Jumlah Kamar Mandi</label>
                            <input value="{{ old('jumlah_kamar') }}" type="number" required class="form-control"
                                name="kamar_mandi">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Carport</label>
                            <input value="{{ old('jumlah_kamar') }}" type="number" required class="form-control"
                                name="carport">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Luas Kavling</label>
                        <div class="input-group mb-3">
                            <input value="{{ old('luas_tanah') }}" type="number" min="0" required name="luas_tanah"
                                class="form-control" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">m2</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Luas Bangunan</label>
                        <div class="input-group mb-3">
                            <input value="{{ old('luas_bangunan') }}" type="number" min="0" required name="luas_bangunan"
                                class="form-control" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">m2</span>
                        </div>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">No Listrik</label>
                            <input value="{{ old('listrik') }}" type="number" required class="form-control"
                                name="listrik">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">No PAM</label>
                            <input value="{{ old('pam') }}" type="number" required class="form-control" name="pam">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Masukkan Gambar(bisa lebih dari 1)</label>
                        <input required type="file" class="form-control" name="image[]" placeholder="address" multiple>

                    </div>
                </div>
                <a href="{{ route('properti') }}" class="btn btn-warning mt-4">Kembali</a>
                <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('after-script')
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".realprocode").remove();
            });
        });
    </script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script>
        $(document).ready(function () {
            getProv();
            $('#select_prov').trigger('change');
            $('#name_prov').val($('#select_prov option:selected').text());
        });

        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })

            $('.multiple2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
            })
            // alert('halo');
        })


        function getProv() {
            $.ajax({
                type: "get",
                url: "https://dev.farizdotid.com/api/daerahindonesia/provinsi",
                dataType: "json",
                success: function (response) {
                    // $("#select_prov").
                    var data = response.provinsi;
                    var options = '';
                    var selected = '';
                    options += '<option value="" >Pilih Provinsi</option>';
                    for(var i=0; i<data.length; i++) { // Loop through the data & construct the options
                    if (data[i].id == 33) {
                        selected = 'selected';
                    }else{
                        selected = '';
                    };
                        options += '<option value="'+data[i].id+'" '+selected+'>'+data[i].nama+'</option>';
                    }

                    // Append to the html
                    $('#select_prov').html(options);
                    $('#select_prov').trigger('change');
                }
            });
        }


        function getKota(id) {
            $('#name_prov').val($('#select_prov option:selected').text());
            $.ajax({
                type: "get",
                url: "https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi="+ id,
                dataType: "json",
                success: function (response) {
                    // $("#select_prov").
                    var data = response.kota_kabupaten;
                    var options = '';
                    var selected = '';
                    options += '<option value="" >Pilih Kota/Kab</option>';
                    for(var i=0; i<data.length; i++) { // Loop through the data & construct the options
                        if (data[i].id == 3374) {
                            selected = 'selected';
                        }else{
                            selected = '';
                        };
                        options += '<option value="'+data[i].id+'" '+selected+'>'+data[i].nama+'</option>';
                    }

                    // Append to the html
                    $('#select_kota').html(options);
                    $('#select_kota').trigger('change');
                }
            });
        }

        function getKecamatan(id) {
            $('#name_kota').val($('#select_kota option:selected').text());
            $.ajax({
                type: "get",
                url: "https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota="+ id,
                dataType: "json",
                success: function (response) {
                    // $("#select_prov").
                    var data = response.kecamatan;
                    var options = '';
                    var selected = '';
                    options += '<option value="" >Pilih Kecamatan</option>';
                    for(var i=0; i<data.length; i++) { // Loop through the data & construct the options
                        if (data[i].id == 3374010) {
                            selected = 'selected';
                        }else{
                            selected = '';
                        };
                        options += '<option value="'+data[i].id+'" '+selected+'>'+data[i].nama+'</option>';
                    }

                    // Append to the html
                    $('#select_kec').html(options);
                    $('#select_kec').trigger('change');
                }
            });
        }
        function getKelurahan(id) {
            $('#name_kec').val($('#select_kec option:selected').text());
            $.ajax({
                type: "get",
                url: "https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan="+ id,
                dataType: "json",
                success: function (response) {
                    // $("#select_prov").
                    var data = response.kelurahan;
                    var options = '';
                    var selected = '';
                    options += '<option value="" >Pilih Kelurahan</option>';
                    for(var i=0; i<data.length; i++) { // Loop through the data & construct the options
                        if (data[i].id == 3374010011) {
                            selected = 'selected';
                        }else{
                            selected = '';
                        };
                        options += '<option value="'+data[i].id+'" '+selected+'>'+data[i].nama+'</option>';
                    }

                    // Append to the html
                    $('#select_kel').html(options);
                    $('#select_kel').trigger('change');

                }
            });
        }

        $("#select_kel").on('change', function (params) {
            $('#name_kel').val($(this).find('option:selected').text());
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
