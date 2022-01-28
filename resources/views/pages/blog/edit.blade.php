@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Blog</h5>
        <p class="card-description">blog yang telah diedit akan muncul di halaman Blog</p>
        <form action="{{route('blog.update', $blog->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                    <label for="">Judul</label>
                  <input type="text" value="{{old('judul', $blog->judul)}}" required class="form-control" name="judul"  aria-label="First name">
                </div>
                <div class="col">
                    <label for="">Deskripsi</label>
                    <textarea class="form-control"  name="desc" aria-label="With textarea">{{old('desc', $blog->desc)}}</textarea>

                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-6">
                    <label for="">Foto Header</label>
                  <input type="file" class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div>
            </div>

            <div class="row mt-4" id="images">
                @foreach ($image as $item)
                    <div class="col wrapper" >
                        <img onclick="image()" src="{{ url('blog_image/' . $item->image) }}" width="200px" height="200px" alt="">
                        <a href="{{route('blogimg.delete', $item->id)}}" class="btn btn-danger hapus mt-3">hapus gambar</a>
                    </div>
                @endforeach

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

@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }
    </style>
@endpush
