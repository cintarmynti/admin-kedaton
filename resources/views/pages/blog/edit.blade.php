@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit blog</h5>
        <p class="card-description">blog yang telah ditampilkan akan muncul di halaman blog</p>
        <form action="{{route('blog.update', $blog->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                  <input type="text" value="{{old('judul', $blog->judul)}}" required class="form-control" name="judul" placeholder="judul" aria-label="First name">
                </div>
                <div class="col">
                    <textarea class="form-control" placeholder="deskripsi" name="desc" aria-label="With textarea">{{old('desc', $blog->desc)}}</textarea>

                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Foto Header</label>
                  <input type="file" class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div>
            </div>

            <div class="row mt-4">

                <div class="input-group realprocode control-group lst increment" >
                    <div class="col">
                        <label for="">Foto deskripsi Blog</label> <br>
                        <input type="file" name="image[]" class="myfrm form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-success" type="button"> <i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                          </div>
                    </div>


                </div>
                <div class="clone hide">
                  <div class="realprocode control-group lst input-group" style="margin-top:10px">
                    <div class="col">
                        <label for="">Foto deskripsi Blog</label> <br>
                        <input type="file" name="image[]" class="myfrm form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                          </div>
                    </div>


                  </div>
                </div>
        </div>


                <a href="{{route('blog')}}" class="btn btn-warning mt-4">kembali</a>
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
