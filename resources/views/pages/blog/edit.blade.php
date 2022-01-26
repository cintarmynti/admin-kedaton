@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit blog</h5>
        <p class="card-description">blog yang telah diedit akan muncul di halaman blog</p>
        <form action="{{route('blog.update', $blog->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                    <label for="">Judul</label>
                  <input type="text" value="{{old('judul', $blog->judul)}}" required class="form-control" name="judul" placeholder="judul" aria-label="First name">
                </div>
                <div class="col">
                    <label for="">Deskripsi</label>
                    <textarea class="form-control" placeholder="deskripsi" name="desc" aria-label="With textarea">{{old('desc', $blog->desc)}}</textarea>

                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-6">
                    <label for="">Foto Header</label>
                  <input type="file" class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
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
