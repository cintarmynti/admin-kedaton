@extends('layouts.default')

@section('content')
<div class="card" id="images">
    <div class="card-body">
        <div class="open-email-content">
            <div class="mail-header">
                <div class="mail-title">
                    @if ($complain->status == 'diajukan')
                    <span class="badge bg-warning btn"  data-complain_id="{{ $complain->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal">Diajukan <i class="fa-solid fa-edit"></i></span>
                        {{-- <i class="fa-solid fa-house"></i> --}}
                    @elseif ($complain->status == 'diproses')
                    <span class="badge bg-primary btn"  data-complain_id="{{ $complain->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal">Diproses <i class="fa-solid fa-edit"></i></span>
                    @elseif($complain->status == 'selesai')
                    <span class="badge bg-success btn"  data-complain_id="{{ $complain->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal">Selesai <i class="fa-solid fa-edit"></i></span>
                    @endif
                    <h4 class="mt-5">Catatan Complain</h4>
                </div>
            </div>
        </div>
        <div class="mail-text">

            {{$complain->catatan}}
            {{-- {!! $blog->desc !!} --}}
        </div>
        <div class="mail-attachment">
            <span class="attachment-info"><i class="fas fa-paperclip m-r-xxs"></i>{{ $image->count() }} Attachments</span>
            <div class="mail-attachment-files">
                @foreach ($image as $item)
                    <div class="card">
                        <img onclick="image()" src="{{ url('storage/' . $item->image) }}" class="card-img-top"
                            style="height: 100px; width:200px; object-fit:cover">
                        <div class="card-body" style="padding-left: 28px">
                            <a href="{{route('complainimg.delete', $item->id)}}" width="200px" class="btn btn-danger hapus mt-3">hapus gambar</a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="ml-5 mb-5">
        <a href="{{ route('complain') }}" class="btn btn-primary mt-4">kembali</a>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form action="{{route('complain.status')}}" method="post">
            @csrf
            @method('patch')
            {{-- <input type="text" value="{{}}"> --}}
            <select class="form-select" id="stat" name="status" aria-label="Floating label select example">
                <option selected="">Pilih Status</option>
                <option value="diajukan">Diajukan</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
              </select>
              <input type="hidden" name="user_id" id="user_id">
              <input type="hidden" name="complain_id" id="id_complain">

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">ubah status</button>
              </div>
         </form>
        </div>

      </div>
    </div>
  </div>

</div>

@endsection

@push('after-script')
<script>
    function image() {
        const viewer = new Viewer(document.getElementById('images'), {
            viewed() {
                viewer.zoomTo(1);
            },
        });
    }



    $('#exampleModal').on('show.bs.modal', function(event) {
        console.log('halo');
        var button = $(event.relatedTarget)
        var id = button.data('complain_id')

        $.ajax({
            type: 'get',
            url: "/complain/detail/" + '{{request()->route('id')}}',
            dataType: 'json',
            success: function(response) {
                console.log(response);

                $("#stat").val(response.status)
                $('#id_complain').val(response.id);
                // alert(response.status);
                $('#user_id').val(response.user_id);
                // $('#id_rumah').val(response.id_rumah);
                // $('#panic_id').val(response.id);

            }
        });

    })
</script>
@endpush

