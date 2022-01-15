@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan User</h5>
        <p class="card-description">User yang telah ditampilkan akan muncul di halaman user</p>
        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                  <input type="text" required class="form-control" name="name" placeholder="name" aria-label="First name">
                </div>
                <div class="col">
                  <input type="number" required class="form-control" name="nik" placeholder="nik" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" required class="form-control" name="alamat" placeholder="alamat" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" required class="form-control" name="phone" placeholder="phone" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="file" required class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div>
            </div>
                <a href="{{route('user')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection
