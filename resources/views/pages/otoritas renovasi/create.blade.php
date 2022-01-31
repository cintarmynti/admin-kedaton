@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Otoritas Renovasi</h5>
        <p class="card-description">Otoritas Renovasi yang telah ditampilkan akan muncul di halaman renovasi</p>
        <form action="{{route('renovasi.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-4">
                <div class="col">
                    <label for="">Nama Pengguna</label>
                    <select class="form-select" name="user_id" aria-label="Default select example">
                        <option disabled selected="">Pilih User</option>
                        @foreach($user as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach

                      </select>
                </div>

                <div class="col">
                    <label for="">No Rumah</label>
                    <select class="form-select" name="rumah_id" aria-label="Default select example">
                        <option disabled selected="">Pilih No Rumah</option>
                        @foreach($nomer as $no)
                        <option value="{{ $no->id }}">{{ $no->no_rumah }}</option>
                        @endforeach

                      </select>
                </div>


            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Tanggal Mulai</label>
                    <input type="date" required class="form-control"  name="tanggal_mulai"  aria-label="Last name">
                  </div>
                <div class="col">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" required class="form-control"  name="tanggal_akhir"  aria-label="Last name">
                </div>

            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Tambah Gambar</label>
                    <input required type="file" class="form-control" name="image[]" placeholder="tambah gambar" multiple>
                </div>

            </div>


            <div class="row mt-4">

                    <label for="">Catatan Renovasi</label>
                    <textarea class="post" class="form-control"  name="catatan_renovasi" aria-label="With textarea"></textarea>

                    <label for="">Catatan Biasa</label>
                    <textarea class="post"  name="catatan_biasa"  aria-label="With textarea"></textarea>

            </div>

            <div class="row mt-4">

            </div>

                <a href="{{route('renovasi')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection

@push('after-script')
<script type="text/javascript">
    $(document).ready(function() {
      $(".btn-success").click(function(){
          var lsthmtl = $(".clone").html();
          $(".increment").after(lsthmtl);
      });
      $("body").on("click",".btn-danger",function(){
          $(this).parents(".realprocode").remove();
      });
    });
</script>

<script>
      $(document).ready(function() {
        $('.post').summernote({
            placeholder: "Ketikan sesuatu disini . . .",
            height: '100'
        });
    });
</script>
@endpush


@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }
    </style>
@endpush


