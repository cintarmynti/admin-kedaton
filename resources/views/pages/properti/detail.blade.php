@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Detail Bangunan</h5>
        <p class="card-description"></p>

        <div class="row mt-4 border border-5 ">
            <div class="col border-end">
                <p><b>Cluster</b></p>
                <p>{{ $properti->cluster->name }}</p>
            </div>

            <div class="col">
                <p><b>No Rumah</b> </p>
                <p>{{ $properti->no_rumah }}</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Provinsi</b></p>
                <p>{{ $properti->provinsi }}</p>
            </div>

            <div class="col">
                <p><b>Kabupaten/Kota</b> </p>
                <p>{{ $properti->kabupaten }}</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Kecamatan</b></p>
                <p>{{ $properti->kecamatan }}</p>
            </div>

            <div class="col">
                <p><b>Kelurahan</b> </p>
                <p>{{ $properti->kelurahan }}</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>No Listrik</b></p>
                <p>{{ $properti->no_listrik }}</p>
            </div>

            <div class="col">
                <p><b>No PAM</b></p>
                <p>{{ $properti->no_pam_bsd }}</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>RT</b></p>
                <p>{{ $properti->RT }}</p>
            </div>

            <div class="col">
                <p><b>RW</b></p>
                <p>{{ $properti->RW }}</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Lantai</b></p>
                <p>{{ $properti->lantai }}</p>
            </div>

            <div class="col">
                <p><b>Jumlah Kamar</b></p>
                <p>{{ $properti->jumlah_kamar }}</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Kamar Mandi</b></p>
                <p>{{ $properti->kamar_mandi }}</p>
            </div>

            <div class="col">
                <p><b>Carport</b></p>
                <p>{{ $properti->carport }}</p>
                </p>

            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Luas Kavling</b></p>
                <p>{{ $properti->luas_tanah }} m2</p>
            </div>

            <div class="col">
                <p><b>Luas Bangunan</b></p>
                <p>{{ $properti->luas_bangunan }} m2</p>
            </div>
        </div>

        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Penghuni</b></p>
                <p>{{ $properti->penghuni != null ? $properti->penghuni->name : '' }}</p>
            </div>

            <div class="col">
                <p><b>Pemilik</b></p>
                <p>{{ $properti->pemilik != null ? $properti->pemilik->name : '' }}</p>
            </div>
        </div>


        <div class="row mt-4 border border-5">
            <div class="col border-end">
                <p><b>Alamat</b> </p>
                <p>{{ $properti->alamat }}</p>
            </div>

            <div class="col">
                <p><b>Biaya IPKL</b></p>
                <p>Rp {{ number_format($properti->tarif_ipkl, 2, ',', '.') }} / Bulan</p>

            </div>
        </div>

        <div class="row mt-3" id="images">
            @foreach ($image as $item)
            <div class="col-md-3 wrapper mb-3">
                <img onclick="image()" src="{{ asset('storage/' . $item->image) }}" style="height: 150px; width:100%; object-fit:cover" alt="">
                <div>
                    <a href="{{route('propertiimg.delete', $item->id)}}" width="200px" class="btn btn-danger hapus mt-3">hapus gambar</a>
                </div>
            </div>
            @endforeach

        </div>



        <a href="{{ url()->previous() }}" class="btn btn-warning mt-4">kembali</a>


        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Riwayat Penghuni</h5>
                {{-- <p class="card-description">
                        <a class="btn btn-primary" href="{{ route('banner.create') }}">Tambah Banner</a>
                </p> --}}
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Nama</th>
                            <th scope="col">tanggal</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($penghuni as $bnr)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $bnr->penghuni->name }}</td>
                            <td>{{ $bnr->created_at }}</td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
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

    .panjang {
        width: 200px;
    }
</style>
@endpush