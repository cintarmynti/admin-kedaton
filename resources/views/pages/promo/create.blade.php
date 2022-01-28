@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan promo</h5>
        <p class="card-description">promo yang telah ditampilkan akan muncul di halaman user</p>
        <form action="{{route('promo.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="">Judul</label>
                  <input type="text" required class="form-control" name="judul"  aria-label="First name">
                </div>

                <div class="col-md-6">
                    <label for="">Link</label>
                    <input type="text" required class="form-control" name="link"  aria-label="First name">
                  </div>


                  <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="">Masukkan Gambar</label>
                      <input id="filePhoto" type="file" required class="form-control" name="photo"  aria-label="First name">
                      <img id="output" class="mb-3" style="max-height: 200px; max-width: 300px">
                    </div>
                </div>
            </div>



                <a href="{{route('promo')}}" class="btn btn-warning mt-4">kembali</a>
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
