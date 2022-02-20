@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Penghuni</h5>
        {{-- <p class="card-description">Pengguna yang telah ditambahkan akan muncul di halaman pengguna</p> --}}
        <form action="{{ route('user.storePenghuni') }}" method="POST" enctype="multipart/form-data">
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

                <div class="col">
                    {{-- <label for="formGroupExampleInput" class="form-label">Alamat</label> --}}
                    <input value="{{request()->id}}" type="hidden" required class="form-control" name="properti_id" aria-label="First name">
                </div>
            </div>



            <a href="{{ url()->previous() }}" class="btn btn-warning mt-4">kembali</a>

            <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>


        </form>



    </div>

@endsection
