@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Otoritas Renovasi</h5>
        <p class="card-description">Otoritas Renovasi yang telah diedit akan muncul di halaman renovasi</p>
        <form action="{{route('renovasi.update', $renovasi->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mt-4">
                <div class="col">
                    <label for="">Nama</label>
                    <select class="form-select" name="user_id" aria-label="Default select example">
                        <option disabled selected="">nama user</option>
                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $renovasi->user_id ? 'selected' : '' }}>
                                {{ $lis->name }}
                            </option>
                        @endforeach

                      </select>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Tanggal Mulai</label>
                    <input type="date" required class="form-control" value="{{old('tanggal_mulai', $renovasi->tanggal_mulai)}}"  name="tanggal_mulai" placeholder="tanggal mulai" aria-label="Last name">
                  </div>
                <div class="col">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" required class="form-control" value="{{old('tanggal_akhir', $renovasi->tanggal_akhir)}}" placeholder="tanggal berakhir" name="tanggal_akhir"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Catatan Renovasi</label>
                    <textarea class="form-control" name="catatan_renovasi" aria-label="With textarea">{{old('catatan_renovasi', $renovasi->catatan_renovasi)}}</textarea>
                  </div>
                <div class="col">
                    <label for="">Catatan Deskripsi</label>
                    <textarea class="form-control"  name="catatan_biasa"  aria-label="With textarea">{{old('catatan_biasa', $renovasi->catatan_biasa)}}</textarea>
                </div>
            </div>

            @foreach ($image as $item)
            <div class="col">
                <img src="{{url('renovasi_image/'.$item->image)}}" onclick="image()"  width="200px" height="200px" alt="">
                <a href="{{route('renovasiimg.delete', $item->id)}}" class="btn btn-danger hapus mt-3">hapus gambar</a>
            </div>
            @endforeach



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
@endpush

@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }
    </style>
@endpush
