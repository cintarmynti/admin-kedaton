@extends('layouts.default')

@section('content')
<div class="row">
    @if ($total == 0)

    @else
    <div class="col-md-12  mb-3">
        Ingin menangani semuanya ?
        <b style="cursor: pointer;"><a class="text-danger" href="/panic-button/dashboard-all">Tangani Semua</a></b>
    </div>
    @endif
   
    @forelse($panic as $p)
    <div>
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card card-panic">
                <div class="card-body">
                    <h6>Butuh Penanganan</h6>
                    <h1>{{$p->name}}-{{$p->no_rumah}}</h1>
                    <hr>
                    <a href="/panic-button/dashboard/{{$p->id}}" class="btn btn-block btn-md btn-danger">TANGANI</a>
                </div>
            </div>
        </div>


    @empty

    @endforelse

    {{-- <div class="col-md-6 col-xl-3 mb-3">
        <div class="card card-panic">
            <div class="card-body">
                <h6>Butuh Penanganan</h6>
                <h1>KX-34</h1>
                <hr>
                <button class="btn btn-block btn-md btn-danger">TANGANI</button>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card card-panic">
            <div class="card-body">
                <h6>Butuh Penanganan</h6>
                <h1>KX-34</h1>
                <hr>
                <button class="btn btn-block btn-md btn-danger">TANGANI</button>
            </div>
        </div>
    </div> --}}
</div>
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card stat-widget">
            <div class="card-body">
                <h5 class="card-title">Jumlah Pengguna</h5>
                <h2>{{ $customer }}</h2>
                <p><a href="{{route('user')}}">pengguna</a> </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-widget">
            <div class="card-body">
                <h5 class="card-title">Listing disewakan</h5>
                <h2>{{ $disewakan }}</h2>
                <p><a href="{{route('listing')}}">listing</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-widget">
            <div class="card-body">
                <h5 class="card-title">Listing dijual</h5>
                <h2>{{ $dijual }}</h2>
                <p><a href="{{route('listing')}}">listing</a></p>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-widget">
            <div class="card-body">
                <h5 class="card-title">Complain</h5>
                <h2>{{ $complain }}</h2>
                <p><a href="{{route('complain')}}">Complain</a></p>

            </div>
        </div>
    </div>
</div>
<div class="row">
    {{-- <div id="blink">
            TES TES ​
        </div> --}}
</div>

@endsection

@push('before-style')
<style>
    @keyframes blinking {
        0% {
            background-color: #e53935;
            border: 3px solid #e53935;
            color: white
        }

        100% {
            background-color: white;
            border: 3px solid #e53935;
            color: #e53935
        }
    }

    #blink {
        width: 200px;




        height: 200px;
        animation: blinking 1s infinite;
    }
</style>
@endpush
