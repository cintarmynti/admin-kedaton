@extends('layouts.default');

@section('content')
<form action="{{route('banner.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" for="">no rumah</label>
          <input type="text" required class="form-control" name="judul"  aria-label="First name">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="">Link</label>
            <input type="text" required class="form-control" name="link"  aria-label="First name">
          </div>

          <div class="col-md-6">
            <div class="row mt-4">
                <div class="col">
                    <label class="form-label" for="">Masukkan Gambar</label>
                  <input id="filePhoto" type="file" required class="form-control" name="photo"  aria-label="First name">
                  <img id="output" class="mb-3" style="max-height: 200px; max-width: 300px">
                </div>
            </div>
          </div>
    </div>

        <a href="{{route('banner')}}" class="btn btn-warning mt-4">kembali</a>
        <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
</form>
@endsection
