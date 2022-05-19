@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Complain</h5>
        <p class="card-description">
            {{-- <a class="btn btn-primary" href="{{route('complain.create')}}">Tambah Complain</a> --}}
            <a onclick="excel()" class="btn btn-success my-3" target="_blank"><i class="fa-regular fa-xl mr-1 fa-file-excel"></i> Excel</a>
            <form action="/complain" method="GET">
                <div class="row">
                        <div class="col-md-3">
                            <label for="">Mulai Tanggal</label>
                            <input type="date" id="from_date" class="form-control" value="{{request()->start_date}}" name="start_date">
                        </div>
                        <div class="col-md-3">
                            <label for="">Sampai Tanggal</label>
                            <input type="date" id="to_date" class="form-control" value="{{request()->end_date}}" name="end_date">
                        </div>
                        <div class="col-md-3">
                            <label for="">Status Pembayaran</label>
                            <select class="form-select" name="status" id="status" value="{{request()->status}}" aria-label="Default select example">
                                <option selected="" value="" disabled>pilih status complain</option>
                                @if (request()->status == 'diajukan')
                                <option value="diajukan" selected>Diajukan</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                @elseif (request()->status == 'diproses')
                                <option value="diajukan" >Diajukan</option>
                                <option value="diproses" selected>Diproses</option>
                                <option value="selesai">Selesai</option>
                                @elseif (request()->status == 'selesai')
                                <option value="diajukan">Diajukan

                                </option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai" selected>Selesai</option>
                                @elseif (request()->status == null)
                                <option value="diajukan">Diajukan</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                @endif
                              </select>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <button class="btn btn-primary" type="submit"><i data-feather="search"></i></button>
                            <a href="/complain" class="btn btn-primary" type="button"><i data-feather="refresh-cw"></i></a>

                        </div>
                </div>
                </form>
        </p>
        <div class="table-responsive">
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">id</th>
              {{-- user id --}}
              <th scope="col">Nama</th>
              <th scope="col">Alamat</th>
              <th scope="col">catatan</th>
              <th scope="col">status</th>
              <th scope="col">Tanggal</th>
              <th scope="col">detail foto</th>
              {{-- <th scope="col">aksi</th> --}}
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
                <td>{{$com->alamat}}</td>
                <td>{{  substr($com->catatan , 0, 10) }}</td>
                <td>
                    @if ($com->status == 'diajukan')
                    <div class="d-flex">
                        <span class="badge bg-warning btn"  data-complain_id="{{ $com->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal">Diajukan <i class="fa-solid fa-edit"></i></span>
                        {{-- <i class="fa-solid fa-house"></i> --}}
                    </div>

                    @elseif ($com->status == 'diproses')
                    <span class="badge bg-primary btn"  data-complain_id="{{ $com->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal">Diproses <i class="fa-solid fa-edit"></i></span>
                    @elseif($com->status == 'selesai')
                    <span class="badge bg-success btn"  data-complain_id="{{ $com->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal">Selesai <i class="fa-solid fa-edit"></i></span>
                    @endif
                </td>
                <td>
                    {{$com->created_at}}
                </td>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                     <form action="{{route('complain.status')}}" method="post">
                        @csrf
                        @method('patch')
                        {{-- <input type="text" value="{{}}"> --}}
                        <select class="form-select" id="stat" name="status" aria-label="Floating label select example">
                            <option selected="">Pilih Status</option>
                            <option value="diajukan">Diajukan</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                          </select>
                          <input type="hidden" name="user_id" id="user_id">
                          <input type="hidden" name="complain_id" id="id_complain">

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">ubah status</button>
                          </div>
                     </form>
                    </div>

                  </div>
                </div>
              </div>

                <td><a href="{{route('complain.detail.image', $com->id)}}">lihat detail</a></td>
                {{-- <td >
                    <div class="d-flex">
                        <a href="{{route('complain.edit',$com->id)}}" class="btn btn-warning fa-regular fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="edit laporan complain"></a>
                        <button type="submit" class="btn btn-danger delete fa-solid fa-trash-can" data-id="{{ $com->id }}" data-toggle="tooltip" data-placement="top" title="delete laporan complain"></button>


                    </div>

                </td> --}}
              </tr>
              @endforeach


          </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

@push('before-style')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootsrap/bootsrap5/css/bootstrap.min.css')}}">

@endpush

@push('after-script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#myTable').DataTable();
        // });

        var APP_URL = {!! json_encode(url('/')) !!}
        console.log(APP_URL);

        function excel(){

            var fromDate = $('#from_date').val();
            // alert('halo');
            var toDate = $('#to_date').val();
            var status = $('#status').val();
            console.log(toDate);
            if(status == null){
                window.open(`${APP_URL}/complain/export_excel?start_date=${fromDate}&end_date=${toDate}`)
            }
            window.open(`${APP_URL}/complain/export_excel?start_date=${fromDate}&end_date=${toDate}&status=${status}`)
        }
    </script>

    <script>

     $('#exampleModal').on('show.bs.modal', function(event) {
        console.log('halo');
        var button = $(event.relatedTarget)
        var id = button.data('complain_id')

        $.ajax({
            type: 'get',
            url: "/complain/detail/" + id,
            dataType: 'json',
            success: function(response) {
                // console.log(response);

                $("#stat").val(response.status)
                $('#id_complain').val(response.id);
                // alert(response.status);
                $('#user_id').val(response.user_id);
                // $('#id_rumah').val(response.id_rumah);
                // $('#panic_id').val(response.id);

            }
        });

    })

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
