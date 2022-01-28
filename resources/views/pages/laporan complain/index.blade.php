@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Complain</h5>
        <p class="card-description">
            <a class="btn btn-primary" href="{{route('complain.create')}}">Tambah Complain</a>
        </p>
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">id</th>
              {{-- user id --}}
              <th scope="col">User</th>
              <th scope="col">Pesan komplain</th>
              <th scope="col">detail foto</th>


              <th scope="col">aksi</th>
            </tr>
          </thead>
          <tbody>
              @php
                  $no = 1
              @endphp
              @foreach ($complain as $com)
              <tr>
                <th scope="row">{{$no++}}</th>
                <td>{{$com->user->name}}</td>
                <td>{{$com->pesan_complain}}</td>
                {{-- {{$com->id}} --}}
                <td><a href="{{route('complain.detail', $com->id)}}">lihat detail</a></td>
                <td class="d-flex">
                    <a class="btn btn-warning" href="{{route('complain.edit',$com->id)}}"><i data-feather="edit"></i></a>

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
                    title: "Yakin Menghapus?",
                    text: "Data yang sudah dihapus tidak akan ditampilkan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/complain/delete/" + userId;
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
