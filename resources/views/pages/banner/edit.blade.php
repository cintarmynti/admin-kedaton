@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Banner</h5>
        <p class="card-description">Banner yang telah diedit akan muncul di halaman banner</p>
        <form action="{{route('banner.update', $banner->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <label for="">Judul</label>
                  <input type="text" value="{{old('judul', $banner->judul)}}" required class="form-control" name="judul"  aria-label="First name">
                </div>

                <div class="col-md-6">
                    <label for="">Link</label>
                    <input type="text" value="{{old('link', $banner->link)}}" required class="form-control" name="link"  aria-label="First name">
                </div>

                <div class="row mt-4">
                    <label for="">Masukkan Gambar</label>
                    <div class="col-md-6">
                        <input type="file"  class="form-control" name="photo"  aria-label="First name">
                    </div>
                </div>

            </div>



                <a href="{{route('banner')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection

@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }
    </style>
@endpush
