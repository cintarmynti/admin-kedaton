@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Pengguna</h5>
            <p class="card-description">Pengguna yang telah diedit akan ditampilkan akan muncul di halaman pengguna</p>
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Nama</label>
                        <input type="text" value="{{ old('name', $user->name) }}" class="form-control" name="name"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">NIK</label>
                        <input type="text" value="{{ old('nik', $user->nik) }}" class="form-control" name="nik"
                            aria-label="Last name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">No Telp</label>
                        <input type="text" value="{{ old('phone', $user->phone) }}" class="form-control" name="phone"
                            aria-label="Last name">
                    </div>


                </div>

                <div class="row mt-4">

                    {{-- <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Email</label>
                  <input type="email" value="{{old('email', $user->email)}}"  class="form-control" name="email"  aria-label="First name">
                </div> --}}
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" aria-label="Last name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Alamat</label>
                        <input type="text" value="{{ old('alamat', $user->alamat) }}" class="form-control" name="alamat"
                            aria-label="First name">
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Foto Pengguna</label>
                        <br>
                        <img id="output" src="{{ asset('storage/' . $user->photo_identitas) }}" class="mt-3 mb-2"
                            style="height: 200px; width: 200px;object-fit:cover">
                        <input type="file" id="filePhoto" class="form-control" name="photo_identitas"
                            aria-label="First name">
                    </div>
                    <div class="col-md-4">
                        <label for="formGroupExampleInput" class="form-label">Foto KTP</label>
                        <br>
                        <img id="output" src="{{ asset('storage/' . $user->photo_identitas) }}" class="mt-3 mb-2"
                            style="height: 200px; width: 300px;object-fit:cover">
                        <input type="file" id="filePhoto" class="form-control" name="photo_ktp" aria-label="First name">
                    </div>
                </div>
                {{-- <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Foto Pengguna</label>
                  <input type="file" id="filePhoto"  class="form-control" name="photo_identitas"  aria-label="First name">
                    @if ($user->photo_identitas == null)

                    @else
                    <img id="output"  src="{{ asset('storage/' . $user->photo_identitas) }}" class="mt-3 " style="max-height: 200px; max-width: 300px">
                    @endif

                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <label for="formGroupExampleInput" class="form-label">Alamat</label>
                  <input type="text" value="{{old('alamat', $user->alamat)}}"  class="form-control" name="alamat"  aria-label="First name">
                </div>
            </div> --}}



                <a href="{{ url()->previous() }}" class="btn btn-warning mt-4">kembali</a>

                <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>
            </form>

        </div>
    </div>
@endsection

@push('before-style')
    <style>
        .form-label {
            font-weight: 500;
        }

    </style>
@endpush

@push('after-script')
    <script>
        $(function() {
            $("#filePhoto").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output").attr("src", x);
                console.log(event);
            });
        });
    </script>
@endpush
