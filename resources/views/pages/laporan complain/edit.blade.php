@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Otoritas complain</h5>
        <p class="card-description">Otoritas complain yang telah diedit akan muncul di halaman complain</p>
        <form action="{{route('complain.update', $complain ->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mt-4">
                <div class="col-md-6">
                <label for="">nama</label>
                    <select class="form-select" name="user_id" aria-label="Default select example">
                        <option disabled selected="">nama user</option>
                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $complain->user_id ? 'selected' : '' }}>
                                {{ $lis->name }}
                            </option>
                        @endforeach

                      </select>
                </div>

                <div class="col-md-6">
                    <label for="">Pesan Complain</label>
                    <textarea class="form-control" placeholder="catatan complain" name="pesan_complain" aria-label="With textarea">{{$complain->pesan_complain}}</textarea>
                </div>

            </div>

            <a href="{{route('complain')}}" class="btn btn-warning mt-4">kembali</a>
            <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
            </div>
            </div>



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
