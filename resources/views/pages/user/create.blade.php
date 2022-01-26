@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan User</h5>
        <p class="card-description">User yang telah ditambahkan akan muncul di halaman user</p>
        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                  <input type="text" required class="form-control" name="name" placeholder="Name" aria-label="First name">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">NIK</label>
                  <input type="number" required class="form-control" name="nik" placeholder="NIK" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Alamat</label>
                  <input type="text" required class="form-control" name="alamat" placeholder="Alamat" aria-label="First name">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">No Telp</label>
                  <input type="text" required class="form-control" name="phone" placeholder="No Telp" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="formGroupExampleInput" class="form-label ">Foto Pengguna</label>
                  <input type="file" required class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div>
                <img id="preview-image" src=""
                      alt="preview image" style="max-height: 250px;">
            </div>
                <a href="{{route('user')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection

@push('after-script')
<script type="text/javascript">
    $('#image').change(function(){

    let reader = new FileReader();
    reader.onload = (e) => {
      $('#preview-image').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);

   });
  </script>
@endpush
