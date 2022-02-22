@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Penghuni</h5>
            <a type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                Tooltip on top
            </a>
            <p class="card-description">
                <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah Penghuni dan Properti</a>
                <a href="/user/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
            </p>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        {{-- user id --}}
                        <th scope="col">Nama</th>
                        <th scope="col">nik</th>
                        <th scope="col">Tanggal Masuk</th>
                        {{-- <th scope="col">rumah</th> --}}
                        {{-- <th scope="col">status </th> --}}
                        {{-- <th scope="col">alamat</th>
                        <th scope="col">No telp</th>
                        <th scope="col">detail Photo</th> --}}
                        {{-- <th scope="col">Riwayat pembayaran</th> --}}
                        <th scope="col">aksi</th>
                    </tr>
                </thead>
                <tbody id="images">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            {{-- @dd($user->pemilik) --}}
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nik }}</td>
                            <td>{{ $user->created_at }}</td>
                            {{-- <td>

                            </td> --}}
                            {{-- <td>{{$user->status_penghuni}}</td> --}}
                            {{-- <td>{{ $user->alamat }}</td>
                            <td>{{ $user->phone }}</td>
                            <td >
                                @if ($user->photo_identitas != null)
                                    <img src="{{ asset('storage/' . $user->photo_identitas) }}" id="image" onclick="image()" style="height: 100px; width:150px; object-fit:cover" alt="">
                                @endif
                            </td> --}}
                            {{-- <td><a href="/user/detail/{{ $user->id }}">lihat detail</a></td> --}}
                            <td>
                                <div class="d-flex">
                                    {{-- <a class="mx-1" href="{{ route('user.edit', $user->id) }}"><i
                                        data-feather="edit"></i></a> --}}

                                    {{-- <button type="submit" class="mx-1 btn-danger delete" data-id="{{ $user->id }}"
                                    data-nama="">
                                    <i data-feather="trash"></i>
                                </button> --}}

                                    {{-- <a class="mx-1" href="{{ route('user.profile', $user->id) }}"><i
                                            data-feather="user"></i></a> --}}
                                            {{-- <a type="button" class="btn btn-primary fa-solid fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">

                                            </a> --}}
                                    <a class="mx-1 btn btn-primary fa-solid fa-eye" type="button" href="{{ route('user.detail', $user->id) }}" data-toggle="tooltip" data-placement="top" title="detail user"></a>
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
    <script src="https://unpkg.com/@popperjs/core@2"></script>
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

            const viewer = new Viewer(document.getElementById('images'), {
                viewed() {
                    viewer.zoomTo(1);
                },
            });
        }
    </script>
@endpush
