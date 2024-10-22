@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Renovasi</h5>
        <p class="card-description">
            <a class="btn btn-primary" href="{{route('renovasi.create')}}">Tambah Renovasi</a>
            <a href="{{route('renovasi.excel')}}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>

        </p>
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">id</th>
              {{-- user id --}}
              <th scope="col">pengguna</th>
              <th scope="col">no rumah</th>
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
                <td>{{$com->nomer->no_rumah}}</td>
                <td>{{$com->tanggal_mulai}}</td>
                <td>{{$com->tanggal_akhir}}</td>
                <td>{!! $com->catatan_renovasi !!}</td>
                <td>{!! $com->catatan_biasa !!}</td>

                <td><a href="{{route('renovasi.detail', $com->id)}}">lihat detail</a></td>
                <td >
                    <div class="d-flex">
                        <a href="{{route('renovasi.edit',$com->id)}}" class="btn btn-warning fa-regular fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="edit renovasi"></a>

                        <button type="submit" class="btn btn-danger delete fa-solid fa-trash-can" data-id="{{ $com->id }}" data-toggle="tooltip" data-placement="top" title="delete renovasi"></button>

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
@endpush

@push('after-script')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                        window.location = "/renovasi/delete/" + userId;
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
