@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        @if (session()->has('failed'))
        {{-- <div class="alert alert-danger" role="alert">
            {{ session('failed') }}
          </div> --}}

          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <h5 class="card-title">Pembayaran Internet dan Listrik</h5>
        <p class="card-description">
            {{-- <a class="btn btn-primary" href="{{ route('ipkl.create') }}">Tambah IPKL</a> --}}
        </p>
        <div class="table-responsive">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    {{-- user id --}}
                    <th scope="col">dibayar oleh</th>
                    <th scope="col">pada tanggal</th>
                    <th scope="col">bank</th>
                    <th scope="col">nominal</th>
                    <th scope="col">tipe</th>
                    <th scope="col">bukti tf</th>
                    <th scope="col">status</th>
                    <th scope="col">aksi</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($bayar as $item)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->bank}}</td>
                        <td> Rp{{number_format($item->nominal,2,',','.')}}</td>
                        <td>@if ($item->type == 3)
                            internet
                            @elseif ($item->type == 4)
                            PLN
                        @endif</td>
                        <td><img src="{{$item->bukti_tf}}" width="150" height="100" alt=""></td>
                        <td><span
                            class="badge @if ($item->status == 0)
                                bg-warning
                            @elseif($item->status == 1)
                                bg-success
                            @else
                                bg-danger
                            @endif
                            "/>
                            @if ($item->status == 0)
                                pending
                            @elseif($item->status == 1)
                                sudah <br> dibayar
                            @else
                                pembayaran <br> ditolak
                            @endif

                        </span></td>
                        <td>
                            @if ($item->status == 0)
                            <div class="d-flex">
                                <a class="btn btn-success mx-1" data-bukti="{{ $item->bukti_tf }}"
                                    data-bayar_id="{{ $item->id }}" data-toggle="modal"
                                    data-target="#successModal" href="{{ route('ipkl.status', $item->id) }}"><i
                                        data-feather="check"></i></a>


                            {{-- ini buat nolak --}}
                            <a class="btn btn-danger" data-bukti="{{ $item->bukti_tf }}"
                                data-cancel_id="{{ $item->id }}" data-toggle="modal"
                                data-target="#exampleCancelModal" href="{{ route('ipkl.status', $item->id) }}"><i
                                    data-feather="x"></i></a>
                            </div>
                            @else

                            @endif



                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

           <!-- Modal Penolakan -->
           <div class="modal fade" id="exampleCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
           aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Masukkan Alasan ditolak</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form action="/mobile-pulsa/tolak" method="POST">
                           @csrf
                           @method('patch')
                           {{-- <img src="" width="400" height="300" id="bukti_tf2" alt=""> --}}
                           <input type="text" required name="alasan_penolakan" class="form-control">
                           <input type="hidden" name="user_id" id="user_id2">
                           <input type="hidden" name="type" id="type2">
                           <input type="hidden" name="id" id="id2">


                           {{-- <input type="hidden" name="tagihan_id" id="tagihan_id2"> --}}
                           {{-- <input type="text" name="pembayaran_id" id="pembayaran_id2"> --}}

                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">Save changes</button>
                   </div>
                   </form>
               </div>
           </div>
       </div>

        <!-- Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form action="/mobile-pulsa/bayar" method="POST">
                            @csrf
                            @method('patch')
                            <img src="" width="400" height="300" id="bukti_tf" alt="">
                            <input type="hidden" name="tr_id" id="tr_id">
                            <input type="hidden" name="user_id" id="user_id">
                            <input type="hidden" name="price" id="price">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="id" id="bayar_id">


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
<link rel="stylesheet" href="{{asset('assets/plugins/bootsrap/bootsrap5/css/bootstrap.min.css')}}">
@endpush

@push('before-style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />

@endpush


@push('after-script')
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
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        });

    </script>

<script>
    var APP_URL = {!! json_encode(url('/')) !!}
    // console.log(APP_URL);
    $('#exampleCancelModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('cancel_id')

        $.ajax({
            type: 'get',
            url: "/mobile-pulsa/json/" + id,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#user_id2').val(response.user_id);
                $('#type2').val(response.type);
                $('#id2').val(response.id);


                // alert('halo')
                // $('#user_id2').val(response.user_id);
                // $('#pembayaran_id2').val(response.id);
                // $('#tagihan_id2').val(response.tagihan_id);
                // $('#bukti_tf2').attr('src', APP_URL + '/storage/' +response.bukti_tf);

            }
        });

    })
</script>


<script>
// ini buat yang disetujui

var APP_URL = {!! json_encode(url('/')) !!}
// console.log(APP_URL);
$('#successModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('bayar_id')

    $.ajax({
        type: 'get',
        url: "/mobile-pulsa/json/" + id,
        dataType: 'json',
        success: function(response) {
            // console.log('halo');
            // console.log(response);
            $('#user_id').val(response.user_id);
            $('#bayar_id').val(response.id);
            $('#tr_id').val(response.tr_id);
            $('#price').val(response.nominal);
            $('#type').val(response.type);
            $('#bukti_tf').attr('src',response.bukti_tf);
            // $('#nominal').val(response.nominal);


        }
    });

})
</script>
@endpush
