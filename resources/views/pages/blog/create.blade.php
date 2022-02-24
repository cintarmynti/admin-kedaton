@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan blog</h5>
        <p class="card-description">blog yang telah ditampilkan akan muncul di halaman blog</p>
        <form action="{{route('blog.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <label class="form-label" for="">Judul</label>
                    <input type="text" required class="form-control" name="judul"  aria-label="First name">
                </div>
                <div class="col">
                    <label class="form-label" for="" >Foto Deskripsi(bisa lebih dari 1)</label>
                    <input type="file" name="image[]" class="form-control" name="images[]" placeholder="address" multiple>
                </div>

            </div>

            <div class="row mt-1">
                <div class="col">
                        <label class="form-label" for="" >Foto Header</label>
                  <input type="file" class="form-control" id="filePhoto" name="photo_header"  aria-label="First name" required>
                  <img id="output" class="mb-3" style="max-height: 200px; max-width: 300px">
                </div>


            </div>
            <div class="row mt-1">
                <div class="col">
                    <label class="form-label" for="">Deskripsi</label>
                    {{-- <textarea class="form-control" id="post" rows="12"  name="desc" aria-label="With textarea"></textarea> --}}
                    <textarea id="konten" class="form-control" name="desc" rows="10" cols="50"></textarea>

                </div>

            </div>

                <a href="{{route('blog')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection


@push('after-script')



<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script>
   var konten = document.getElementById("konten");
     CKEDITOR.replace(konten,{
     language:'en-gb'
   });
   CKEDITOR.config.allowedContent = true;
</script>

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
