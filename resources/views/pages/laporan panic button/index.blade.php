@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Laporan Panic Button</h5>
        <p class="card-description">
            <a href="/panic-button/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
            {{-- <a class="btn btn-primary" href="{{route('complain.create')}}">Tambah <Complain></Complain></a> --}}
             <form action="/panic-button" method="GET">
            <div class="row">
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="start_date">
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="end_date">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">GET</button>
                        <a href="/panic-button" class="btn btn-primary" type="button">Refresh</a>

                    </div>
            </div>
            </form>
        </p>
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">id</th>
              {{-- listing id --}}
              <th scope="col">rumah</th>
              {{-- User id --}}
              <th scope="col">user</th>
              <th scope="col">keterangan</th>
              <th scope="col">status keterangan</th>
              <th scope="col">Tanggal</th>
              <th scope="col">aksi</th>
            </tr>
          </thead>
          <tbody>
              @php
                  $no = 1
              @endphp
              @foreach ($panic as $pan)
              <tr>
                <th scope="row">{{$no++}}</th>
                <td>{{$pan->properti->no_rumah}}</td>
                <td>{{$pan->user->name}}</td>
                <td>{{$pan->keterangan}}</td>

                <td>
                    @if ( $pan->status_keterangan == 'checked')
                    <span class="badge bg-success">checked</span>
                    @else
                    <span class="badge bg-danger">not checked</span>
                    @endif
                </td>
                <td>{{$pan->created_at}}</td>


                <td>
                    @if ($pan->status_keterangan == 'not checked')
                    <a class="btn btn-success" href="{{ route('panic.status', $pan->id) }}"><i
                            data-feather="check"></i></a>
                @else

                @endif
                    {{-- <a href="{{route('complain.edit',$com->id)}}"><i data-feather="edit"></i></a> --}}
                    {{-- <form action="{{route('panic.delete', $pan->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i data-feather="trash"></i>
                        </button>
                    </form> --}}
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
    </script>
@endpush
