@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Listing</h5>
        <p class="card-description">Listing yang telah ditampilkan akan muncul di halaman listing</p>
        <form action="{{route('listing.update', $listing->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                  <input type="text" value="{{old('alamat', $listing->alamat)}}" required class="form-control" name="alamat" placeholder="alamat" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" value="{{old('no_rumah', $listing->no_rumah)}}" required class="form-control" name="no" placeholder="no" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" value="{{old('RT', $listing->RT)}}" required class="form-control" name="RT" placeholder="RT" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" value="{{old('RW', $listing->RW)}}" required class="form-control" name="RW" placeholder="RW" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" value="{{old('lantai', $listing->lantai)}}" required class="form-control" name="lantai" placeholder="lantai" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" value="{{old('jumlah_kamar', $listing->jumlah_kamar)}}" required class="form-control" name="jumlah_kamar" placeholder="jumlah kamar" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                  <input type="text" value="{{old('luas_tanah', $listing->luas_tanah)}}" required class="form-control" name="luas_tanah" placeholder="luas tanah" aria-label="First name">
                </div>
                <div class="col">
                  <input type="text" value="{{old('luas_bangunan', $listing->luas_bangunan)}}" required class="form-control" name="luas_bangunan" placeholder="luas bangunan" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <select class="form-control" id="type" name="penghuni">
                        <option disabled selected="">penghuni</option>

                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $listing->user_id_penghuni ? 'selected' : '' }}>
                                {{ $lis->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select class="form-select" name="pemilik" aria-label="Default select example">
                        <option disabled selected="">pemilik</option>
                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $listing->user_id_pemilik ? 'selected' : '' }}>
                                {{ $lis->name }}
                            </option>
                        @endforeach
                      </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Status Kepemilikan</option>
                        <option value="dihuni" {{ 'dihuni' == $listing->status ? 'selected' : '' }}>dihuni</option>
                        <option value="disewakan" {{ 'disewakan' == $listing->status ? 'selected' : '' }}>disewakan</option>
                        <option value="dijual" {{ 'dijual' == $listing->status ? 'selected' : '' }}>dijual</option>
                      </select>
                </div>
                <div class="col">
                    <input type="text" value="{{old('harga', $listing->harga)}}" required class="form-control" name="harga" placeholder="harga(optional)" aria-label="Last name">
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
