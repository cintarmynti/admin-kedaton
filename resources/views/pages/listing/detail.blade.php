@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Bangunan</h5>
            <p class="card-description"></p>

            <div class="row mt-4">
                <div class="col">
                    <p>Alamat</p>
                    <p>{{ $listing->alamat }}</p>
                </div>

                <div class="col">
                    <p>No Rumah</p>
                    <p>{{ $listing->no_rumah }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <p>RT</p>
                    <p>{{ $listing->RT }}</p>
                </div>

                <div class="col">
                    <p>RW</p>
                    <p>{{ $listing->RW }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <p>Lantai</p>
                    <p>{{ $listing->lantai }}</p>
                </div>

                <div class="col">
                    <p>Jumlah Kamar</p>
                    <p>{{ $listing->jumlah_kamar }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <p>Luas Kavling</p>
                    <p>{{ $listing->luas_tanah }}</p>
                </div>

                <div class="col">
                    <p>Luas Bangunan</p>
                    <p>{{ $listing->luas_bangunan }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <p>Penghuni</p>
                    <p>{{ $listing->user_penghuni->name }}</p>
                </div>

                <div class="col">
                    <p>Pemilik</p>
                    <p>{{ $listing->user_pemilik->name }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <p>Status</p>
                    <p>{{ $listing->status }}</p>
                </div>

                <div class="col">
                    <p>Harga</p>
                    <p>{{ $listing->harga }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <p>Biaya IPKL</p>
                    <p>Rp {{ number_format($listing->tarif_ipkl, 2, ',', '.') }}</p>

                </div>

            </div>

            <div class="row mt-4" id="images">
                @foreach ($image as $item)
                    <div class="col wrapper" >
                        <img onclick="image()" src="{{ url('files/' . $item->image) }}" width="200px" height="200px" alt="">
                        <a href="{{route('listingimg.delete', $item->id)}}" class="btn btn-danger hapus mt-3">hapus gambar</a>
                    </div>
                @endforeach

            </div>

        </div>

        <div class="m-5">
            <a href="{{ route('listing') }}" class="btn btn-warning mt-4">kembali</a>

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
        }


    </style>
@endpush
