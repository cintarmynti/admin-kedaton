@extends('layouts.default')

@section('content')
<div id="images" class="card">
    @foreach ($image as $item)
    <div class="col">
        <img src="{{url('renovasi_image/'.$item->image)}}" onclick="image()"  width="200px" height="200px" alt="">
        <a href="{{route('renovasiimg.delete', $item->id)}}" class="btn btn-danger hapus mt-3">hapus gambar</a>
    </div>
    @endforeach
    <div class="m-5">
        <a href="{{ route('renovasi') }}" class="btn btn-warning mt-4">kembali</a>

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
