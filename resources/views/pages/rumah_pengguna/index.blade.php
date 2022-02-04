@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Rumah Penggguna</h5>
            <p class="card-description">
                <a class="btn btn-primary" href="/rumah-pengguna/create">Tambah Rumah Pengguna</a>
                {{-- <a href="/user/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
            </p>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        {{-- user id --}}
                        <th scope="col">pengguna</th>
                        <th scope="col">no rumah</th>
                        <th scope="col">aksi</th>
                    </tr>
                </thead>
                <tbody id="images">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($rumah as $user)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $user->user->name}}</td>
                            <td>{{ $user->nomer_rumah->no_rumah}}</td>
                            <td >
                                <div class="d-flex">
                                    <a class="btn btn-warning" href="rumah-pengguna/{{ $user->id }}/edit"><i
                                        data-feather="edit"></i></a>

                                <button type="submit" class="btn btn-danger delete" data-id="{{ $user->id }}"
                                    data-nama="">
                                    <i data-feather="trash"></i>
                                </button>
                                </div>


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
                        window.location = "/rumah-pengguna/delete/" + userId;
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
    </script>


@endpush
