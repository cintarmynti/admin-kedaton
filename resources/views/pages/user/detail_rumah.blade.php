@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($user[0]->pemilik_id != null)
                
            <h5 class="card-title">Detail Rumah {{ $user[0]->pemilik->name }}</h5>
            @else
                
            <h5 class="card-title">Detail Rumah {{ $user[0]->penghuni->name }}</h5>
            @endif
            <p class="card-description"></p> 
            <div class="row mt-4 border border-5 ">
                <div class="col border-end">
                    <p><b>Alamat</b> </p>
                    <p>{{ $user[0]->alamat }}</p>
                </div>

            <div class="col">
               <p><b>No Rumah</b> </p>
               <p>{{ $user[0]->no_rumah }}</p>
           </div>
          
               
           
       </div>

       <div class="row mt-4 border border-5">
           <div class="col border-end">
               <p><b>RT</b></p>
               <p>{{ $user[0]->RT }}</p>
           </div>

           <div class="col">
               <p><b>RW</b></p>
               <p>{{ $user[0]->RW }}</p>
           </div>
       </div>

       <div class="row mt-4 border border-5">
           <div class="col border-end">
               <p><b>Lantai</b></p>
               <p>{{ $user[0]->lantai }}</p>
           </div>

           <div class="col">
               <p><b>Jumlah Kamar</b></p>
               <p>{{ $user[0]->jumlah_kamar }}</p>
           </div>
       </div>

       <div class="row mt-4 border border-5">
           <div class="col border-end">
               <p><b>Luas Kavling</b></p>
               <p>{{ $user[0]->luas_tanah }}</p>

           </div>

           <div class="col">
               <p><b>Luas Bangunan</b></p>
               <p>{{ $user[0]->luas_bangunan }}</p>
           </div>
        </div>

       <div class="row mt-4 border border-5">
           <div class="col border-end">
               <p><b>Status</b></p>
               <p>{{ $user[0]->status }}</p>
           </div>

           <div class="col">
               <p><b>Harga</b></p>
               <p>{{ $user[0]->harga }}</p>
           </div>
       </div>

       <div class="row mt-4 border border-5">
           <div class="col">
               <p><b>Biaya IPKL</b></p>
               <p>Rp {{ number_format($user[0]->tarif_ipkl, 2, ',', '.') }}</p>

           </div>

            </div>

        </div>

        <div class="m-4">
            <a href="/user" class="btn btn-warning mt-4">kembali</a>

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
