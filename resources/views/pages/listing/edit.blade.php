@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Listing</h5>
        <p class="card-description">Listing yang telah diedit akan muncul di halaman listing</p>
        <form action="{{route('listing.update', $listing->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                    <label for="">Alamat</label>
                  <input type="text" value="{{old('alamat', $listing->alamat)}}" required class="form-control" name="alamat"  aria-label="First name">
                </div>
                <div class="col">
                    <label for="">No Rumah</label>
                  <input type="text" value="{{old('no_rumah', $listing->no_rumah)}}" required class="form-control" name="no"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">RT</label>
                  <input type="text" value="{{old('RT', $listing->RT)}}" required class="form-control" name="RT" aria-label="First name">
                </div>
                <div class="col">
                    <label for="">RW</label>
                  <input type="text" value="{{old('RW', $listing->RW)}}" required class="form-control" name="RW" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Jumlah Lantai</label>
                  <input type="text" value="{{old('lantai', $listing->lantai)}}" required class="form-control" name="lantai"  aria-label="First name">
                </div>
                <div class="col">
                    <label for="">Jumlah Kamar</label>
                  <input type="text" value="{{old('jumlah_kamar', $listing->jumlah_kamar)}}" required class="form-control" name="jumlah_kamar"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Luas Kavling</label>

                    <div class="input-group mb-3">
                        <input type="number" value="{{old('luas_tanah', $listing->luas_tanah)}}" min="0" required name="luas_tanah"  class="form-control"  aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">m2</span>
                      </div>
                </div>
                <div class="col">
                    <label for="">Luas Bangunan</label>
                    <div class="input-group mb-3">
                        <input type="number" value="{{old('luas_bangunan', $listing->luas_bangunan)}}" min="0" required name="luas_bangunan"  class="form-control"  aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">m2</span>
                      </div>

                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Penghuni</label>
                    <select class="form-select" name="penghuni" aria-label="Default select example">
                        <option disabled selected="">penghuni</option>
                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $listing->user_id_penghuni ? 'selected' : '' }}>
                                {{ $lis->name }}
                            </option>
                        @endforeach
                      </select>


                </div>
                <div class="col">
                    <label for="">Pemilik</label>

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
                    <label for="">Status Kepemilikan</label>
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Status Kepemilikan</option>
                        <option value="dihuni" {{ 'dihuni' == $listing->status ? 'selected' : '' }}>dihuni</option>
                        <option value="disewakan" {{ 'disewakan' == $listing->status ? 'selected' : '' }}>disewakan</option>
                        <option value="dijual" {{ 'dijual' == $listing->status ? 'selected' : '' }}>dijual</option>
                      </select>
                </div>
                <div class="col">
                    <label for="">Harga</label>
                    <input type="text" value="{{old('harga', $listing->harga)}}" required class="form-control" name="harga"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="">Pilih Cluster</label>
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Pilih Cluster</option>
                        @foreach($cluster as $clu)

                        <option value="{{ $clu->id }}" {{ $clu->id == $listing->cluster_id ? 'selected' : '' }}>
                            {{ $clu->name }}
                        </option>
                        @endforeach
                      </select>
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

@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }
    </style>
@endpush
