@extends('layouts.default')

@section('content')
<div id="images">
    @foreach ($image as $item)
    <div class="col">
        <img src="{{url('renovasi_image/'.$item->image)}}" onclick="image()"  width="200px" height="200px" alt="">

    </div>
    @endforeach
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
