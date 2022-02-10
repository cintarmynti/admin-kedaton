@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Properti</h5>
        <p class="card-description">Properti yang telah diedit akan muncul di halaman properti</p>
        <form action="{{route('properti.update', $properti->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col">
                    <label for="">Alamat</label>
                  <input type="text" value="{{old('alamat', $properti->alamat)}}" required class="form-control" name="alamat"  aria-label="First name">
                </div>
                <div class="col">
                    <label for="">No Rumah</label>
                  <input type="text" value="{{old('no_rumah', $properti->no_rumah)}}" required class="form-control" name="no"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">No Listrik</label>
                    <input value="{{ old('listrik', $properti->no_listrik) }}" type="number" required class="form-control" name="listrik"
                        aria-label="First name">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">No PAM</label>
                    <input value="{{ old('pam', $properti->no_pam_bsd) }}" type="number" required class="form-control" name="pam"
                        aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">RT</label>
                  <input type="number" value="{{old('RT', $properti->RT)}}" required class="form-control" name="RT" aria-label="First name">
                </div>
                <div class="col">
                    <label for="">RW</label>
                  <input type="number" value="{{old('RW', $properti->RW)}}" required class="form-control" name="RW" aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Jumlah Lantai</label>
                  <input type="number" value="{{old('lantai', $properti->lantai)}}" required class="form-control" name="lantai"  aria-label="First name">
                </div>
                <div class="col">
                    <label for="">Jumlah Kamar</label>
                  <input type="number" value="{{old('jumlah_kamar', $properti->jumlah_kamar)}}" required class="form-control" name="jumlah_kamar"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Luas Kavling</label>

                    <div class="input-group mb-3">
                        <input type="number" value="{{old('luas_tanah', $properti->luas_tanah)}}" min="0" required name="luas_tanah"  class="form-control"  aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">m2</span>
                      </div>
                </div>
                <div class="col">
                    <label for="">Luas Bangunan</label>
                    <div class="input-group mb-3">
                        <input type="number" value="{{old('luas_bangunan', $properti->luas_bangunan)}}" min="0" required name="luas_bangunan"  class="form-control"  aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">m2</span>
                      </div>

                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="">Penghuni</label>
                    <select class="form-select multiple2" name="penghuni" aria-label="Default select example">
                        <option disabled selected="">Pilih Penghuni</option>
                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $properti->penghuni_id ? 'selected' : '' }}>
                                {{ $lis->name }}
                            </option>
                        @endforeach
                      </select>


                </div>
                <div class="col">
                    <label for="">Pemilik</label>

                    <select class="form-select multiple2" name="pemilik" aria-label="Default select example">
                        <option disabled selected="">Pilih Pemilik</option>
                        @foreach($user as $lis)
                            <option value="{{ $lis->id }}" {{ $lis->id == $properti->pemilik_id ? 'selected' : '' }}>
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
                        <option disabled selected="">Pilih Status Kepemilikan</option>
                        <option value="dihuni" {{ 'dihuni' == $properti->status ? 'selected' : '' }}>dihuni</option>
                        <option value="disewakan" {{ 'disewakan' == $properti->status ? 'selected' : '' }}>disewakan</option>
                        <option value="dijual" {{ 'dijual' == $properti->status ? 'selected' : '' }}>dijual</option>
                      </select>
                </div>
                <div class="col">
                    <label for="">Harga</label>
                    <input type="text" value="{{old('harga', $properti->harga)}}" required class="form-control" name="harga"  aria-label="Last name" onkeyup="onchange_comma(this.id, this.value)">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="">Pilih Cluster</label>
                    <select class="form-select select2" name="cluster_id" aria-label="Default select example">
                        <option disabled selected="">Pilih Cluster</option>
                        @foreach($cluster as $clu)
                        <option value="{{ $clu->id }}" {{ $clu->id == $properti->cluster_id ? 'selected' : '' }}>
                            {{ $clu->name }}
                        </option>
                        @endforeach
                      </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Masukkan Gambar(bisa lebih dari 1)</label>
                    <input type="file" class="form-control" name="image[]" placeholder="address" multiple>

                </div>
            </div>

            <div class="row mt-4" id="images">
                @foreach ($image as $item)
                    <div class="col-md-3 wrapper" >
                        <img onclick="image()" src="{{ asset('storage/' . $item->image) }}" width="200px" height="200px" alt="">
                        <div class="panjang mb-4">
                            <a href="{{route('propertiimg.delete', $item->id)}}" width="200px" class="btn btn-danger hapus mt-3">hapus gambar</a>
                        </div>
                    </div>
                @endforeach

            </div>


            <div class="row mt-4">
                {{-- <div class="col">
                  <input type="file" required class="form-control" name="photo_identitas" placeholder="photo identitas" aria-label="First name">
                </div> --}}
            </div>
                <a href="{{route('properti')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
        </form>

    </div>
</div>
@endsection

@push('after-script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script>
        function image() {
            const viewer = new Viewer(document.getElementById('images'), {
                viewed() {
                    viewer.zoomTo(1);
                },
            });
        }
        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })

            $('.multiple2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
            })
            // alert('halo');
        })

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
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
