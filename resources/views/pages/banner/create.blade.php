@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Banner</h5>
        <p class="card-description">Banner yang telah ditampilkan akan muncul di halaman user</p>
        <form action="{{route('banner.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="">Judul</label>
                  <input type="text" required class="form-control" name="judul" placeholder="judul" aria-label="First name">
                </div>

                <div class="col-md-6">
                    <label for="">Link</label>
                    <input type="text" required class="form-control" name="link" placeholder="link" aria-label="First name">
                  </div>

                  <div class="col-md-6">
                    <div class="row mt-4">
                        <div class="col">
                            <label for="">Masukkan Gambar</label>
                          <input type="file" required class="form-control" name="photo" placeholder="photo" aria-label="First name">
                        </div>
                    </div>
                  </div>
            </div>

                <a href="{{route('banner')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection
