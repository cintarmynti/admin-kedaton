@extends('layouts.default')

@section('content')
<div class="card"  id="images">
    @foreach ($image as $item)
    <div class="col">
        <img onclick="image()" src="{{url('blog_image/'.$item->image)}}" width="200px" height="200px" alt="">
        <a href="{{route('blogimg.delete', $item->id)}}" class="btn btn-danger hapus mt-3">hapus gambar</a>


    </div>
    @endforeach
    <div class="m-5">
        <a href="{{ route('blog') }}" class="btn btn-warning mt-4">kembali</a>
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
