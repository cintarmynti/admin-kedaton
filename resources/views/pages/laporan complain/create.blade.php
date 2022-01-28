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
                    <label for="">Tambahkan Gambar</label>
                    <input required type="file" class="form-control" name="image[]" placeholder="address" multiple>

                </div>

            </div>

            <div class="row mt-1">

                <div class="col">
                    <label for="">catatan complain</label>
                    <textarea  class="form-control post"  name="pesan_complain" aria-label="With textarea"></textarea>
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
