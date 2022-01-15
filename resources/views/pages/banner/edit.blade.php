@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Banner</h5>
        <p class="card-description">Banner yang telah ditampilkan akan muncul di halaman user</p>
        <form action="{{route('banner.update', $banner->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col">
                  <input type="text" value="{{old('judul', $banner->judul)}}" required class="form-control" name="judul" placeholder="judul" aria-label="First name">
                </div>

            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" value="{{old('link', $banner->link)}}" required class="form-control" name="link" placeholder="link" aria-label="First name">
                </div>

            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="file"  class="form-control" name="photo" placeholder="photo" aria-label="First name">
                </div>
            </div>
                <a href="{{route('banner')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection
