@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Otoritas Renovasi</h5>
        <p class="card-description">Otoritas Renovasi yang telah ditampilkan akan muncul di halaman renovasi</p>
        <form action="{{route('renovasi.update', $renovasi->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mt-4">
                <div class="col">
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
                    <input type="date" required class="form-control" value="{{old('tanggal_mulai', $renovasi->tanggal_mulai)}}" placeholder="tanggal mulai" name="tanggal_mulai" placeholder="tanggal mulai" aria-label="Last name">
                  </div>
                <div class="col">
                    <input type="date" required class="form-control" value="{{old('tanggal_akhir', $renovasi->tanggal_akhir)}}" placeholder="tanggal berakhir" name="tanggal_akhir" placeholder="tanggal akhir" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <textarea class="form-control" placeholder="catatan renovasi" name="catatan_renovasi" aria-label="With textarea">{{old('catatan_renovasi', $renovasi->catatan_renovasi)}}</textarea>
                  </div>
                <div class="col">
                    <textarea class="form-control" placeholder="catatan biasa" name="catatan_biasa"  aria-label="With textarea">{{old('catatan_biasa', $renovasi->catatan_biasa)}}</textarea>
                </div>
            </div>



            <div class="row mt-4">

                    <div class="input-group realprocode control-group lst increment" >
                      <input type="file" name="image[]" class="myfrm form-control">
                      <div class="input-group-btn">
                        <button class="btn btn-success" type="button"> <i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                      </div>
                    </div>
                    <div class="clone hide">
                      <div class="realprocode control-group lst input-group" style="margin-top:10px">
                        <input type="file" name="image[]" class="myfrm form-control">
                        <div class="input-group-btn">
                          <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                        </div>
                      </div>
                    </div>
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
@endpush
