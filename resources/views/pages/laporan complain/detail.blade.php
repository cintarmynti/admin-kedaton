@extends('layouts.default')

@section('content')
<div class="card" id="images">
    <div class="row mt-2" id="images">
        @foreach ($image as $item)
            <div class="col wrapper" >
                <img onclick="image()" src="{{ url('complain_image/' . $item->image) }}" width="200px" height="200px" alt="">
                <div class="panjang">
                    <a href="{{route('complainimg.delete', $item->id)}}" width="200px" class="btn btn-danger hapus mt-3">hapus gambar</a>
                </div>
            </div>
        @endforeach

    </div>
    <div class="m-5">
        <a href="{{ route('complain') }}" class="btn btn-warning mt-4">kembali</a>

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

