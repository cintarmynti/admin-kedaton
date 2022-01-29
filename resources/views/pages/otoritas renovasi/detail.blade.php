@extends('layouts.default')

@section('content')
<div  class="card">
    <div class="row mt-2" id="images">
    @foreach ($image as $item)
                    <div class="col wrapper" >
                        <img onclick="image()" src="{{ url('renovasi_image/' . $item->image) }}" width="200px" height="200px" alt="">
                        <div class="panjang">
                            <a href="{{route('renovasiimg.delete', $item->id)}}" width="200px" class="btn btn-danger hapus mt-3">hapus gambar</a>
                        </div>
                    </div>
                @endforeach
    <div class="m-5">
        <a href="{{ route('renovasi') }}" class="btn btn-warning mt-4">kembali</a>
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
</script>
@endpush

@push('before-style')
    <style>
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
