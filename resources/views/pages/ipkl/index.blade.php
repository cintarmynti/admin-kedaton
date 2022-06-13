@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Tagihan IPKL</h5>
            <p class="card-description">
                <a class="btn btn-primary" href="{{ route('ipkl.create') }}"><i class="fa-regular fa-xl mr-1 fa-square-plus"></i> IPKL</a>
                <button type="button" onclick="excel()" class="btn btn-success my-3" target="_blank"><i class="fa-regular fa-xl mr-1 fa-file-excel"></i> Excel</button>
                <form action="/ipkl" method="GET">
                    <div class="row">
                            <div class="col-md-3">
                                <label for="">Mulai Tanggal</label>
                                <input type="date" id="from_date" class="form-control" value="{{request()->start_date}}" name="start_date">
                            </div>
                            <div class="col-md-3">
                                <label for="">Sampai Tanggal</label>
                                <input type="date" id="to_date" class="form-control" value="{{request()->end_date}}" name="end_date">
                            </div>
                            <div class="col-md-3">
                                <label for="">Status Pembayaran</label>
                                <select class="form-select" name="status" id="status" value="{{request()->status}}" aria-label="Default select example">
                                    <option selected="" value="" disabled>pilih status pembayaran</option>
                                    @if (request()->status == 1)
                                    <option value="1" selected>Belum Dibayar</option>
                                    {{-- <option value="2">Pending</option> --}}
                                    <option value="3">Sudah Dibayar</option>
                                    @elseif (request()->status == 2)
                                    <option value="1" >Belum Dibayar</option>
                                    {{-- <option value="2" selected>Pending</option> --}}
                                    <option value="3">Sudah Dibayar</option>
                                    @elseif (request()->status == 3)
                                    <option value="1">Belum Dibayar</option>
                                    {{-- <option value="2">Pending</option> --}}
                                    <option value="3" selected>Sudah Dibayar</option>
                                    @elseif (request()->status == null)
                                    <option value="1">Belum Dibayar</option>
                                    {{-- <option value="2">Pending</option> --}}
                                    <option value="3">Sudah Dibayar</option>
                                    @endif
                                  </select>
                            </div>
                            <div class="col-md-3">
                                <br>
                                <button class="btn btn-primary" type="submit"><i data-feather="search"></i></button>
                                <a href="/ipkl" class="btn btn-primary" type="button"><i data-feather="refresh-cw"></i></a>

                            </div>
                    </div>
                    </form>
                    {{-- <form action="/ipkl" method="GET">
                        <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option selected="">pilih status pembayaran</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Sudah Dibayar</option>
                                      </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit">GET</button>
                                    <a href="/ipkl" class="btn btn-primary" type="button">Refresh</a>

                                </div>
                        </div>
                        </form> --}}
            </p>
            <div class="table-responsive">
            <table class="table mt-5" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        {{-- user id --}}
                        <th scope="col">cluster id</th>
                        <th scope="col">no rumah</th>
                        <th scope="col">periode Pembayaran</th>
                        <th scope="col">jumlah pembayaran</th>
                        <th scope="col">Nama</th>
                        <th scope="col">status</th>
                        <th scope="col">aksi</th>

                    </tr>
                </thead>
                <tbody id="images">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($ipkl as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->cluster->name }}</td>
                            <td>{{ $i->nomer->no_rumah }}</td>
                            <td>{{ $i->periode_pembayaran }}</td>
                            <td>Rp.{{ number_format($i->jumlah_pembayaran,2,',','.') }}</td>
                           @php
                               $properti = \App\Models\Properti::where('id', $i -> properti_id)->with('pemilik')->with('penghuni')->first();
                           @endphp
                           <td>{{$properti-> penghuni_id ? $properti->penghuni->name : $properti->pemilik->name }}</td>

                           {{-- <td>
                              @if ($properti-> penghuni_id)
                               {{ $properti->penghuni->name}}
                              @elseif ($properti-> penghuni_id == null)
                                {{$properti->pemilik->name}}
                              @else
                              -
                              @endif
                           </td> --}}
                            <td><span
                                    class="badge @if ($i->status == 1 || $i->status == 4)
                                        bg-danger
                                    @elseif($i->status == 2)
                                        bg-warning
                                    @else
                                        bg-success
                                    @endif
                                    "/>
                                    @if ($i->status == 1)
                                         belum dibayar
                                    @elseif($i->status == 2)
                                         pending
                                    @elseif ($i->status == 4)
                                        Pembayaran gagal
                                    @else
                                        success
                                    @endif

                                </span>
                            </td>
                            <td><a href="{{route('ipkl.pembayar', $i->id)}}">lihat</a></td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/ipkl/riwayat-create" method="POST">
                                @csrf
                                @method('patch')
                                <img src="" width="400" height="300" id="bukti_tf" alt="">
                                <input type="text" name="tagihan_id" id="tagihan_id">
                                <input type="text" name="no_rumah" id="no_rumah">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('before-style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
<link rel="stylesheet" href="{{asset('assets/plugins/bootsrap/bootsrap5/css/bootstrap.min.css')}}">

@endpush

@push('after-script')
    <script>
        console.log('halo');
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        var APP_URL = {!! json_encode(url('/')) !!}
        console.log(APP_URL);

        function excel(){

            var fromDate = $('#from_date').val();
            // alert('halo');
            var toDate = $('#to_date').val();
            var status = $('#status').val();
            console.log(toDate);
            if(status == null){
                window.open(`${APP_URL}/ipkl/export_excel?start_date=${fromDate}&end_date=${toDate}`)
            }
            window.open(`${APP_URL}/ipkl/export_excel?start_date=${fromDate}&end_date=${toDate}&status=${status}`)
        }
    </script>
    <script>
        // console.log(APP_URL);



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

@endpush
