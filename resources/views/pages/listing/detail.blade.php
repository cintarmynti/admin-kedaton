@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Detail Bangunan</h5>
        <p class="card-description"></p>

        <div class="row mt-4">
            <div class="col">
                <p>alamat</p>
                <p>{{$listing -> alamat}}</p>
            </div>

            <div class="col">
                <p>no rumah</p>
                <p>{{$listing -> no_rumah}}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <p>RT</p>
                <p>{{$listing -> RT}}</p>
            </div>

            <div class="col">
                <p>RW</p>
                <p>{{$listing -> RW}}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <p>lantai</p>
                <p>{{$listing -> lantai}}</p>
            </div>

            <div class="col">
                <p>jumlah kamar</p>
                <p>{{$listing -> jumlah_kamar}}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <p>luas tanah</p>
                <p>{{$listing -> luas_tanah}}</p>
            </div>

            <div class="col">
                <p>luas bangunan</p>
                <p>{{$listing -> luas_bangunan}}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <p>penghuni</p>
                <p>{{$listing -> user_penghuni ->name}}</p>
            </div>

            <div class="col">
                <p>pemilik</p>
                <p>{{$listing -> user_pemilik ->name}}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <p>status</p>
                <p>{{$listing -> status}}</p>
            </div>

            <div class="col">
                <p>harga</p>
                <p>{{$listing -> harga}}</p>
            </div>
        </div>

    </div>
</div>
@endsection
