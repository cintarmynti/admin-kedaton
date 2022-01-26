@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Otoritas complain</h5>
        <p class="card-description">Otoritas complain yang telah ditampilkan akan muncul di halaman complain</p>
        <form action="{{route('complain.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="">nama</label>
                    <select class="form-select" name="user_id" aria-label="Default select example">
                        <option disabled selected="">nama user</option>
                        @foreach($user as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach

                      </select>
                </div>
                <div class="col-md-6">
                    <label for="">catatan complain</label>
                    <textarea class="form-control" placeholder="catatan complain" name="pesan_complain" aria-label="With textarea"></textarea>
                </div>

            </div>



            <div class="row mt-1">
                <label for="">Tambahkan Gambar</label>
                <div class="col-md-6">
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

            </div>
                <a href="{{route('complain')}}" class="btn btn-warning mt-4">kembali</a>
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
