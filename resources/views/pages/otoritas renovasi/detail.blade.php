@extends('layouts.default')

@section('content')
    @foreach ($image as $item)
    <div class="col">
        <img src="{{url('renovasi_image/'.$item->image)}}" width="200px" height="200px" alt="">

    </div>
    @endforeach
@endsection
