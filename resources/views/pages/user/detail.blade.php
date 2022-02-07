@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Pembayaran</h5>
            <p class="card-description">
                {{-- <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah Pengguna</a> --}}
                {{-- <a href="/user/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
            </p>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        {{-- user id --}}
                        <th scope="col">pengguna</th>
                        <th scope="col">NO RUMAH</th>
                        <th scope="col">DETAIL </th>
                    </tr>
                </thead>
                <tbody id="images">
                    @php
                        $no = 1;
                    @endphp
                    {{-- {{ $user }} --}}
                    @foreach ($user as $us)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            @if ($us->pemilik_id != null)
                                <td>{{ $us->pemilik->name }}</td>
                            @else
                            <td>{{ $us->penghuni->name }}</td>
                            @endif
                            
                            <td>{{ $us->no_rumah }}</td>
                            @if ($us->pemilik_id != null)
                                <td><a href="/user/detail/rumah/{{ $us->pemilik_id }}">lihat detail</a></td>
                                
                            @else
                                <td><a href="/user/detail/rumah/{{ $us->penghuni_id }}">lihat detail</a></td>
                            @endif
                            
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
    </script>


@endpush
