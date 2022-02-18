@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Pengguna</h5>
            <p class="card-description">Pengguna yang telah ditambahkan akan muncul di halaman pengguna</p>
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
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Email</label>
                        <input value="" type="email" required class="form-control" name="email" aria-label="First name">
                    </div>
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
                        <input value="" type="file" id="filePhoto" required class="form-control" name="photo_identitas"
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
            {{-- <p class="card-description">Properti yang telah ditambahkan akan muncul di halaman Properti</p> --}}
            {{-- <form action="{{ route('properti.store') }}" method="POST" enctype="multipart/form-data">
                @csrf --}}
                <div class="row">
                    <div class="col-md-9">
                        <label for="formGroupExampleInput" class="form-label">Alamat</label>
                        <input value="{{ old('alamat') }}" type="text" required class="form-control" name="alamat"
                            aria-label="First name">
                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">No Rumah</label>
                        <input value="{{ old('no') }}" type="text" required class="form-control" name="no"
                            aria-label="Last name">
                    </div>
                </div>


                <div class="row mt-4">

                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">RT</label>
                        <input value="{{ old('RT') }}" type="number" required class="form-control" name="RT"
                            aria-label="First name">
                    </div>
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">RW</label>
                        <input value="{{ old('RW') }}" type="number" required class="form-control" name="RW"
                            aria-label="Last name">
                    </div>
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Lantai</label>
                        <input value="{{ old('lantai') }}" type="number" required class="form-control" name="lantai"
                            aria-label="First name">
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Kamar</label>
                        <input value="{{ old('jumlah_kamar') }}" type="number" required class="form-control"
                            name="jumlah_kamar" aria-label="Last name">
                    </div>
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Kamar Mandi</label>
                        <input value="{{ old('jumlah_kamar') }}" type="number" required class="form-control"
                            name="kamar_mandi" aria-label="Last name">
                    </div>
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Carport</label>
                        <input value="{{ old('jumlah_kamar') }}" type="number" required class="form-control"
                            name="carport" aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-8">
                        <label for="formGroupExampleInput" class="form-label">No Listrik</label>
                        <input value="{{ old('listrik') }}" type="number" required class="form-control" name="listrik"
                            aria-label="First name">
                    </div>

                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Luas Kavling</label>
                        <div class="input-group mb-3">
                            <input value="{{ old('luas_tanah') }}" type="number" min="0" required name="luas_tanah"
                                class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">m2</span>
                        </div>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-md-8">
                        <label for="formGroupExampleInput" class="form-label">No PAM</label>
                        <input value="{{ old('pam') }}" type="number" required class="form-control" name="pam"
                            aria-label="Last name">
                    </div>

                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Luas Bangunan</label>
                        <div class="input-group mb-3">
                            <input value="{{ old('luas_bangunan') }}" type="number" min="0" required name="luas_bangunan"
                                class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">m2</span>
                        </div>

                    </div>
                </div>


                <div class="row mt-4">
                    {{-- <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Penghuni</label>
                    <select class="form-select multiple2" name="penghuni" aria-label="Default select example">
                        <option disabled selected="">Pilih Penghuni</option>
                        @foreach ($user as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Pemilik</label>
                    <select class="form-select multiple2" name="pemilik" aria-label="Default select example">
                        <option disabled selected="">Pilih Pemilik</option>
                        @foreach ($user as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Pilih Cluster</label>

                        <select id="category" class="form-control select2" name="cluster_id"
                            aria-label="Default select example">
                            <option disabled selected="">Pilih Cluster</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Status Kepemilikan</label>

                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Pilih Status Kepemilikan</option>
                        <option value="dihuni">dihuni</option>
                        <option value="disewakan">disewakan</option>
                        <option value="dijual">dijual</option>
                    </select>
                </div> --}}
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Harga</label>

                        <input value="{{ old('harga') }}" type="text" required class="form-control money" id="harga"
                            onkeyup="onchange_comma(this.id, this.value)" name="harga">
                    </div>
                </div>

                <div class="row mt-5 mb-4">


                    <div class="col">
                        <label for="" class="form-label">Masukkan Gambar(bisa lebih dari 1)</label>
                        <input required type="file" class="form-control" name="image[]" placeholder="address" multiple>

                    </div>
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

            $("#filePhoto2").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output2").attr("src", x);
                console.log(event);
            });
        });
        $(document).ready(function() {
            $(".btn-success").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".realprocode").remove();
            });

            $('.select2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })
        });

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
        }
    </script>
@endpush

@push('before-style')
    <style>
        .form-label {
            font-weight: 500;
        }

    </style>
@endpush
