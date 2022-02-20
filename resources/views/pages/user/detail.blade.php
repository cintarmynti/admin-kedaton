@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Rumah {{ $user->name }}</h5>
            <p class="card-description">
                {{-- <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah Pengguna</a> --}}
                {{-- <a href="/user/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
            </p>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">NO RUMAH</th>
                        <th scope="col">ALAMAT</th>
                        <th scope="col">NAMA penghuni</th>
                        <th scope="col">Update PENGHUNI</th>
                        <th scope="col">RIWAYAT PEMBAYARAN</th>
                        <th scope="col">DETAIL PROPERTI</th>
                    </tr>
                </thead>
                <tbody id="images">
                    @php
                        $no = 1;
                    @endphp
                    {{-- {{ $user }} --}}
                    @foreach ($properti as $us)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $us->no_rumah }}</td>

                            <td>{{ $us->alamat }}</td>
                            <td>@if (isset($us->penghuni->name))
                                {{$us->penghuni->name}}
                                @elseif ($us->penghuni_id == null)
                                <p>tidak ada penghuni</p>
                            @endif

                               </td>
                            <td><a href="{{route('user.addPenghuni', $us -> id)}}" data-toggle="modal" data-target="#exampleModal"><i data-feather="user-plus"></i></a></td>
                            <td><a href="{{route('properti.riwayat', $us -> id)}}">lihat detail</a> </td>T
                            <td><a href="/user/detail/rumah/{{ $us->id }}">lihat detail</a></td>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penghuni</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('user.updatePenghuni', $us -> id)}}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <label for="">Pilih User</label>
                                            <select class="form-select" id="countries" name="user_id" class="form_input required">

                                            </select>
                                            <div class="mt-4">
                                                <a  href="{{route('user.addPenghuni', $us -> id)}}">Tambah Penghuni Baru</a>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </tr>

                    </div>
                    @endforeach

                </tbody>
            </table>

            <a href="{{ route('user') }}" class="btn btn-warning mt-4">kembali</a>
        </div>
    </div>


@endsection

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
        });
    </script>
    <script>
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
                        window.location = "/user/delete/" + userId;
                        swal("Data berhasil dihapus!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data anda batal dihapus!");
                    }
                });
        });


        function image() {

            const viewer = new Viewer( document.getElementById('images'), {
                        viewed() {
                            viewer.zoomTo(1);
                        },
                    });
        }

        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('riwayat_id')

            $.ajax({
                type: 'get',
                url: "/user/daftarUser",
                dataType: 'json',
                success: function(response) {
                    var data = response
                    console.log(response);
                    var formoption = "";
                    // $('#user_id').val(response.user_id);
                    $.each(data, function(v, data) {
                        var val = data[v]
                        console.log(data);
                        formoption += "<option value='" + data.id + "'>" + data.name + "</option>";
                    });
                    $('#countries').html(formoption);



                }
            });

        })
    </script>


@endpush
