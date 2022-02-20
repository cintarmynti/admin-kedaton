@extends('layouts.default')
@section('content')
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Detail Profile {{$user -> name}}</h5><a class="mx-1 btn btn-primary" href="{{ route('user.edit', $user->id) }}"><i
                data-feather="edit"></i> Edit Profile</a>
            <p class="card-description"></p>
            <div class="row mt-4 border border-5 ">
                <div class="col border-end">
                    <p><b>email</b> </p>
                    <p>{{$user -> email}}</p>
                </div>

                <div class="col">
                    <p><b>NIK</b> </p>
                    <p>{{$user->nik}}</p>
                </div>
            </div>

            <div class="row mt-4 border border-5">
                <div class="col border-end">
                    <p><b>Alamat</b></p>
                    <p>{{$user -> alamat}}</p>
                </div>

                <div class="col">
                    <p><b>No Telp</b></p>
                    <p>{{$user -> phone}}</p>
                </div>
            </div>

            <div class="row mt-4 border border-5">
                <div class="col border-end">
                    <p><b>Photo Identitas</b></p>
                    <img onclick="image()" src="{{ asset('storage/' . $user -> photo_identitas) }}" style="height: 100px; width:200px; object-fit:cover" height="200px" alt="">


                </div>

                <div class="col">
                    <p><b>Photo KTP</b></p>
                    <img onclick="image()" src="{{ asset('storage/' . $user -> photo_ktp) }}" style="height: 100px; width:200px; object-fit:cover" height="200px" alt="">

                </div>
            </div>

            <div class="row mt-4 border border-5">
                <div class="col border-end">
                    <p><b>Status</b></p>
                    <p>{{$user -> status_penghuni}}</p>
                </div>

                {{-- <div class="col">
                    <p><b>Jumlah Kamar</b></p>
                    <p></p>
                </div> --}}
            </div>



        <div class="m-4">
            <a href="{{ url()->previous() }}" class="btn btn-warning mt-4">kembali</a>

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
