@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Renovasi</h5>
        <p class="card-description">
            <a class="btn btn-primary" href="{{route('renovasi.create')}}">Tambah renovasi</a>
        </p>
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">id</th>
              {{-- user id --}}
              <th scope="col">pengguna</th>
              <th scope="col">tanggal mulai</th>
              <th scope="col">tanggal akhir</th>
              <th scope="col">catatan renovasi</th>
              <th scope="col">catatan biasa</th>
              <th scope="col">detail foto</th>
              <th scope="col">aksi</th>
            </tr>
          </thead>
          <tbody>
              @php
                  $no = 1
              @endphp
              @foreach ($renovasi as $com)
              <tr>
                <th scope="row">{{$no++}}</th>
                <td>{{$com->user->name}}</td>
                <td>{{$com->tanggal_mulai}}</td>
                <td>{{$com->tanggal_akhir}}</td>
                <td>{{$com->catatan_renovasi}}</td>
                <td>{{$com->catatan_biasa}}</td>

                <td><a href="{{route('renovasi.detail', $com->id)}}">lihat detail</a></td>
                <td class="d-flex">
                    <a class="btn btn-warning" href="{{route('renovasi.edit',$com->id)}}"><i data-feather="edit"></i></a>

                        <button type="submit" data-id="{{$com->id}}" class="btn btn-danger delete">
                            <i data-feather="trash"></i>
                        </button>

                </td>
              </tr>
              @endforeach


          </tbody>
        </table>
    </div>
</div>
@endsection

@push('before-style')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
@endpush

@push('after-script')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      });

      $('.delete').click(function() {
            var userId = $(this).attr('data-id')
            swal({
                    title: "yakin menghapus?",
                    text: "data yang sudah dihapus tidak akan ditampilkan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/renovasi/delete/" + userId;
                        swal("data berhasil dihapus!", {
                            icon: "success",
                        });
                    } else {
                        swal("data anda batal dihapus!");
                    }
                });
        });

    </script>


@endpush
