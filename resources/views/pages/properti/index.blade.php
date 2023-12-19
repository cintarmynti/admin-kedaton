@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Properti</h5>
            <p class="card-description">
                <a class="btn btn-primary" href="{{ route('properti.create') }}"><i class="fa-regular fa-xl mr-1 fa-square-plus"></i> </a>
                <a href="/properti/export_excel" class="btn btn-success" target="_blank"><i class="fa-regular fa-xl mr-1 fa-file-excel"></i> </a>
            </p>
            <form action="/properti" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="formGroupExampleInput" class="form-label">Harga Rumah dibawah subquery (<)</label>
                        <input value="{{request()->harga}}" id="harga"  type="text" required class="form-control" name="harga">
                        <p id="pesan" class="text-warning"></p>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <button class="btn btn-primary" type="submit"><i data-feather="search"></i></button>
                    <a href="/properti" class="btn btn-primary" type="button"><i data-feather="refresh-cw"></i></a>
                </div>
            </div>
            </form>

            <div class="table-responsive">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kluster</th>
                        <th scope="col">No Rumah</th>
                        <th scope="col">alamat</th>
                        <th scope="col">detail bangunan</th>
                        <th scope="col">pemilik</th>
                        <th scope="col">penghuni</th>
                        <th scope="col">aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($properti as $p)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $p->cluster_name }}</td>
                            <td>{{ $p->no_rumah }}</td>
                            <td>{{ $p->alamat }}, {{ $p->kelurahan }}, {{ $p->kecamatan }}, {{ $p->kabupaten }},
                                {{ $p->provinsi }}</td>
                            <td><a href="{{ route('properti.detail', $p->id) }}">lihat detail</a></td>
                            <td>
                                @if ($p->status_pengajuan == 1)
                                pengajuan properti oleh pemilik, <a href="" data-toggle="modal"
                                        data-target="#exampleModal" type="button"
                                        data-properti_id="{{ $p->id }}">lihat</a>
                                @elseif ($p->status_pengajuan == 2 || $p->status_pengajuan == 0)
                                    {{ $p->pemilik_id ? $p->pemilik_name : '-' }}
                                @endif
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Penambahan
                                                    Properti Oleh User</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                    <table class="table table-border">
                                                        <tr>
                                                            <td>name</td>
                                                            <td>
                                                                <p id="nama"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>email</td>
                                                            <td>
                                                                <p id="email"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>No Telp</td>
                                                            <td>
                                                                <p id="phone"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>nik</td>
                                                            <td>
                                                                <p id="nik"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>alamat</td>
                                                            <td>
                                                                <p id="alamat"></p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <form action="/properti/tolak-tambahproperti">
                                                        @csrf
                                                        @method('patch')
                                                    <label for="" class="form-label">Alasan Ditolak</label>

                                                    <textarea class="form-control" name="alasan_dibatalkan" required aria-label="With textarea"></textarea>
                                                    {{-- <img src="" width="400" height="300" id="bukti_tf" alt="">
                                                <input type="hidden" name="user_id" id="user_id">
                                                <input type="hidden" name="tagihan_id" id="tagihan_id">
                                                <input type="hidden" name="pembayaran_id" id="pembayaran_id"> --}}

                                            </div>
                                            <div class="modal-footer">

                                                    <input type="hidden" name="pemilik_id" id="pemilik_id4">
                                                    <input type="hidden" name="properti_id" id="properti_id4">

                                                    <button type="submit" class="btn btn-danger"
                                                   >Tolak</button>
                                                </form>
                                            <form action="{{ route('properti.pemilik') }}" method="POST">
                                                @csrf
                                                @method('patch')
                                            <input type="hidden" name="pemilik_id" id="pemilik_id">
                                            <input type="hidden" name="properti_id" id="properti_id">
                                                <button type="submit" class="btn btn-primary">Setujui</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="exampleModalPenghuni" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Penambahan Penghuni
                                                    Properti Oleh User</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                    <table class="table table-border">
                                                        <tr>
                                                            <td>name</td>
                                                            <td>
                                                                <p id="nama2"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>email</td>
                                                            <td>
                                                                <p id="email2"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>No Telp</td>
                                                            <td>
                                                                <p id="phone2"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>nik</td>
                                                            <td>
                                                                <p id="nik2"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>alamat</td>
                                                            <td>
                                                                <p id="alamat2"></p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <form action="/properti/tolak-penghuni">
                                                    <label for="" class="form-label">Masukkan alasan ditolak</label>
                                                    <textarea class="form-control" name="alasan_dibatalkan" required aria-label="With textarea"></textarea>

                                                    {{-- <img src="" width="400" height="300" id="bukti_tf" alt="">
                                                <input type="hidden" name="user_id" id="user_id">
                                                <input type="hidden" name="tagihan_id" id="tagihan_id">
                                                <input type="hidden" name="pembayaran_id" id="pembayaran_id"> --}}

                                            </div>
                                            <div class="modal-footer">

                                                @csrf
                                                    @method('patch')
                                                <input type="hidden" name="penghuni_id" id="penghuni_id3">
                                                <input type="hidden" name="pemilik_id" id="pemilik_id3">
                                                <input type="hidden" name="properti_id" id="properti_id3">

                                                <button type="submit" class="btn btn-danger"
                                                >Tolak</button>
                                            </form>

                                        <form action="{{ route('properti.penghuni_id') }}" method="POST">
                                                @csrf
                                                @method('patch')
                                            <input type="hidden" name="penghuni_id" id="penghuni_id2">
                                            <input type="hidden" name="pemilik_id" id="pemilik_id2">
                                            <input type="hidden" name="properti_id" id="properti_id2">
                                            <button type="submit" class="btn btn-primary">Setujui</button>
                                        </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td>
                                {{-- halo --}}

                            @if ($p->status_pengajuan_penghuni == 1)
                                ada user menambahkan penghuni ini di propertinya, <a href="" data-toggle="modal"
                                    data-target="#exampleModalPenghuni" type="button"
                                    data-properti_id_penghuni="{{ $p->id }}" >lihat</a>
                            @elseif ($p->status_pengajuan_penghuni == 2 || $p->status_pengajuan_penghuni == 0)
                                {{ $p->penghuni_id ? $p->penghuni_name : '-' }}</td>
                            @endif
                            <td>
                                <a href="{{ route('properti.edit', $p->id) }}"
                                    class="btn btn-warning fa-regular fa-pen-to-square" data-toggle="tooltip"
                                    data-placement="top" title="edit properti"></a>
                                {{-- <button type="submit" class="btn btn-danger delete fa-solid fa-trash-can" data-id="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="delete properti">
                                </button> --}}

                            </td>
                        </tr>
                    @endforeach



                </tbody>
            </table>
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

        $('.delete').click(function() {
            var userId = $(this).attr('data-id')
            swal({
                    title: "Yakin Menghapus?",
                    text: "Data yang sudah dihapus tidak akan ditampilkan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/properti/delete/" + userId;
                        swal("Data berhasil dihapus!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data anda batal dihapus!");
                    }
                });
        });
    </script>

    <script>
        var APP_URL = {!! json_encode(url('/')) !!}
        console.log(APP_URL);
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('properti_id')

            $.ajax({
                type: 'get',
                url: "/properti/user/" + id,
                dataType: 'json',
                success: function(response) {
                    // console.log(response);

                    // $('#user_id').val(response.user_id);
                    // $('#pembayaran_id').val(response.id);
                    // $('#tagihan_id').val(response.tagihan_id);
                    // $('#bukti_tf').attr('src', APP_URL + '/' +response.bukti_tf);
                    $('#nama').html(response.name);
                    $('#email').html(response.email)
                    $('#phone').html(response.phone);
                    $('#nik').html(response.nik);
                    $('#alamat').html(response.alamat);
                    $('#penghuni_id').val(response.id);
                    $('#properti_id').val(id);
                    $('#pemilik_id').val(response.id);
                    $('#properti_id4').val(id);
                    $('#pemilik_id4').val(response.id);


                }
            });

        })
    </script>

<script>
    var APP_URL = {!! json_encode(url('/')) !!}
    console.log(APP_URL);
    $('#exampleModalPenghuni').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('properti_id_penghuni')

        $.ajax({
            type: 'get',
            url: "/properti/penghuni/" + id,
            dataType: 'json',
            success: function(response) {
                console.log(response);

                // $('#user_id').val(response.user_id);
                // $('#pembayaran_id').val(response.id);
                // $('#tagihan_id').val(response.tagihan_id);
                // $('#bukti_tf').attr('src', APP_URL + '/' +response.bukti_tf);
                $('#nama2').html(response.penghuni.name);
                $('#email2').html(response.penghuni.email)
                $('#phone2').html(response.penghuni.phone);
                $('#nik2').html(response.penghuni.nik);
                $('#alamat2').html(response.penghuni.alamat);
                $('#penghuni_id2').val(response.penghuni.id);
                $('#pemilik_id2').val(response.pemilik);
                $('#properti_id2').val(id);
                $('#penghuni_id3').val(response.penghuni.id);
                $('#pemilik_id3').val(response.pemilik);
                $('#properti_id3').val(id);


            }
        });

    })
</script>
@endpush
