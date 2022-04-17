@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Penghuni ke Rumah No. {{ $properti->no_rumah }} (cluster
                {{ $properti->cluster->name }})</h5>
            {{-- <p class="card-description">Pengguna yang telah ditambahkan akan muncul di halaman pengguna</p> --}}
            <form action="{{ route('user.storePenghuni') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput">NIK</label>

                        <input type="text" class="form-control" id="nik" name="nik" onkeydown="getUserDetail(this.value)"
                            onkeyup="getUserDetail(this.value)">
                        {{-- <select id="nik" class="form-control select2" name="nik" data-tags="true" onchange="getUserDetail()">
                            <option disabled selected="">Pilih NIK</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->nik }}">{{ $user->nik }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Nama</label>
                        <input value="" type="text" required class="form-control" name="name" id="name"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">No Telp</label>
                        <input value="" type="text" required class="form-control" name="phone" id="phone"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    {{-- <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Email</label>
                        <input value="" type="email" required class="form-control" name="email" id="email"
                            aria-label="First name">
                    </div> --}}
                    {{-- <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Password</label>
                        <input value="" type="password" required class="form-control" name="password" id="password"
                            aria-label="Last name">
                    </div> --}}
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Alamat</label>
                        <input value="" type="text" required class="form-control" name="alamat" id="alamat"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label ">Foto Pengguna</label>
                        <input value="" type="file" id="filePhoto" class="form-control" name="photo_identitas"
                            id="photo_identitas" aria-label="First name">
                        <img id="output" class="mt-3" style="max-height: 200px; max-width: 300px">
                    </div>

                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label ">Foto KTP</label>
                        <input value="" type="file" id="filePhoto2" class="form-control" name="photo_ktp" id="photo_ktp"
                            aria-label="First name">
                        <img id="output2" class="mt-3" style="max-height: 200px; max-width: 300px">
                    </div>



                </div>

                <div class="row mt-4 mb-4">
                    <div class="col">
                        {{-- <label for="formGroupExampleInput" class="form-label">Alamat</label> --}}
                        <input value="{{ request()->id }}" type="hidden" required class="form-control"
                            name="properti_id" aria-label="First name">
                    </div>
                </div>



                <a href="{{ url()->previous() }}" class="btn btn-warning mt-4">kembali</a>

                <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>


            </form>
        </div>
    @endsection

    @push('after-script')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

        <script>
            $(function() {
                $("#filePhoto2").change(function(event) {
                    var x = URL.createObjectURL(event.target.files[0]);
                    $("#output2").attr("src", x);
                    console.log(event);
                });
            });

            $(function() {
                $("#filePhoto").change(function(event) {
                    var x = URL.createObjectURL(event.target.files[0]);
                    $("#output").attr("src", x);
                    console.log(event);
                });
            });

            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: 'Pilih NIK',
                    theme: 'bootstrap4',
                    tags: true
                })

            });

            function getUserDetail(nik) {
                const base = new URL('/', location.href).href;
                var name = $('#name');
                var phone = $('#phone');
                var email = $('#email');
                var password = $('#password');
                var alamat = $('#alamat');
                var photo_identitas = $('#photo_identitas');
                var photo_ktp = $('#photo_ktp');
                var photoImg = $('#output');
                var ktpImg = $('#output2');



                // var nik = $("#nik");

                // $('#nik').on('keyup', function() {
                //     search();
                // });



                $.ajax({
                    url: '/user-detail-json/' + nik,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        // console.log(data);
                        if (jQuery.isEmptyObject(data)) {
                            name.attr('disabled', false).val('');
                            phone.attr('disabled', false).val('');
                            email.attr('disabled', false).val('');
                            alamat.attr('disabled', false).val('');
                            password.attr('disabled', false);
                            photo_identitas.attr('disabled', false).val('');
                            photo_ktp.attr('disabled', false).val('');
                            photoImg.attr("src",'');
                            ktpImg.attr("src", '');
                        } else {
                            console.log(data);
                            console.log(data[0].name);
                            name.attr('disabled', true).val(data[0].name);
                            phone.attr('disabled', true).val(data[0].phone);
                            email.attr('disabled', true).val(data[0].email);
                            alamat.attr('disabled', true).val(data[0].alamat);
                            password.attr('disabled', true);
                            photo_identitas.attr('disabled', true);
                            photo_ktp.attr('disabled', true);
                            photoImg.attr("src",data[0].photo_identitas);
                            ktpImg.attr("src", data[0].photo_ktp);
                        }
                    }
                });
            }
        </script>
    @endpush
