@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Listing</h5>
        <p class="card-description">Listing yang telah ditampilkan akan muncul di halaman listing</p>
        <form action="{{route('listing.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                  <input type="text" required class="form-control" name="alamat" placeholder="alamat" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" required class="form-control" name="no" placeholder="no" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" required class="form-control" name="RT" placeholder="RT" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" required class="form-control" name="RW" placeholder="RW" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" required class="form-control" name="lantai" placeholder="lantai" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" required class="form-control" name="jumlah_kamar" placeholder="jumlah kamar" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" required class="form-control" name="luas_tanah" placeholder="luas tanah" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" required class="form-control" name="luas_bangunan" placeholder="luas bangunan" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <select class="form-select" name="penghuni" aria-label="Default select example">
                        <option disabled selected="">penghuni</option>
                        @foreach($user as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach

                      </select>
                </div>
                <div class="col">
                    <select class="form-select" name="pemilik" aria-label="Default select example">
                        <option disabled selected="">pemilik</option>
                        @foreach($user as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                      </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Status Kepemilikan</option>
                        <option value="dihuni">dihuni</option>
                        <option value="disewakan">disewakan</option>
                        <option value="dijual">dijual</option>
                      </select>
                </div>
                <div class="col">
                    <input type="text" required class="form-control" name="harga" placeholder="harga(optional)" aria-label="Last name">
                </div>
            </div>



            <div class="row mt-4">
                {{-- <div class="col">
                  <input type="file" required class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div> --}}
            </div>
                <a href="{{route('listing')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection
