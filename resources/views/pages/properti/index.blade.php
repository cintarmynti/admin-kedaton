@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Properti</h5>
            <p class="card-description">
                <a class="btn btn-primary" href="{{ route('properti.create') }}">Tambah Properti</a>
                <a href="/properti/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
            </p>
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
                            <td>{{ $p->cluster->name }}</td>
                            <td>{{ $p->no_rumah }}</td>
                            <td>{{ $p->alamat }}, {{$p->kelurahan}}, {{$p->kecamatan}}, {{$p->kabupaten}}, {{$p->provinsi}}</td>
                            <td><a href="{{ route('properti.detail', $p->id) }}">lihat detail</a></td>
                            <td>{{ $p->pemilik ? $p->pemilik->name : '-' }}</td>
                            <td>{{ $p->penghuni ? $p->penghuni->name : '-' }}</td>
                            <td class="d-flex">
                                <a href="{{ route('properti.edit', $p->id) }}" class="btn btn-warning fa-regular fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="edit properti"></a>
                                {{-- <button type="submit" class="btn btn-danger delete fa-solid fa-trash-can" data-id="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="delete properti">
                                </button> --}}

                            </td>
                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('before-style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
@endpush

@push('after-script')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
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
@endpush
