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
                <div class="col-md-6">
                    <label for="">Foto Header</label>
                    <input type="file" id="filePhoto" class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                    <img id="output" src="{{ asset('blog_image/' . $blog->gambar) }}" alt="{{ $blog->gambar }}" class="mt-2" style="max-height: 200px; max-width: 300px">
                </div>
            </div>

            <div class="row mt-1">

                <div class="col">
                    <label for="">Deskripsi</label>
                    <textarea id="post" class="form-control"  name="desc" aria-label="With textarea">{{old('desc', $blog->desc)}}</textarea>

                </div>
            </div>

            <div class="row mt-4" id="images">
                @foreach ($image as $item)
                    <div class="col wrapper" >
                        <img onclick="image()" src="{{ url('blog_image/' . $item->image) }}" style="height: 100px; width:200px; object-fit:cover" alt="">
                        <div class="panjang">
                            <a href="{{route('blogimg.delete', $item->id)}}" class="btn btn-danger hapus mt-3">hapus gambar</a>
                        </div>

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
<script>
    $(document).ready(function() {
        $('#post').summernote({
            placeholder: "Ketikan sesuatu disini . . .",
            height: '200'
        });
    });

    function image() {
            const viewer = new Viewer(document.getElementById('images'), {
                viewed() {
                    viewer.zoomTo(1);
                },
            });
        }
</script>
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

@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }

        .wrapper {
            text-align: center;
           display: flex;
           flex-direction: column;
        }

        .panjang{
            width:200px;
        }
    </style>
@endpush
