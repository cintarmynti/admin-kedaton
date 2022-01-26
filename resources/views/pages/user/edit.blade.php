@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit User</h5>
        <p class="card-description">User yang telah diedit akan ditampilkan akan muncul di halaman user</p>
        <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Nama</label>
                  <input type="text" value="{{old('name', $user->name)}}" required class="form-control" name="name" placeholder="Nama" aria-label="First name">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">NIK</label>
                  <input type="text" value="{{old('nik', $user->nik)}}" required class="form-control" name="nik" placeholder="NIK" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Alamat</label>
                  <input type="text" value="{{old('alamat', $user->alamat)}}" required class="form-control" name="alamat" placeholder="Alamat" aria-label="First name">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">No Telp</label>
                  <input type="text" value="{{old('phone', $user->phone)}}" required class="form-control" name="phone" placeholder="No Telp" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="formGroupExampleInput" class="form-label">Foto Pengguna</label>
                  <input type="file"  class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div>
            </div>
                <a href="{{route('user')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection
