@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Laporan Panic Button</h5>
        <p class="card-description">
            <button type="button" onclick="excel()" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</button>
            {{-- <a class="btn btn-primary" href="{{route('complain.create')}}">Tambah <Complain></Complain></a> --}}
        <form action="/panic-button" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="">Mulai Tanggal</label>
                    <input type="date" id="from_date" class="form-control" value="{{ request()->start_date }}" name="start_date">
                </div>
                <div class="col-md-3">
                    <label for="">Sampai Tanggal</label>
                    <input type="date" id="to_date" class="form-control" value="{{ request()->end_date }}" name="end_date">
                </div>
                <div class="col-md-3">
                    <label for="">Status</label>
                    <select class="form-select" name="status" id="status" value="{{ request()->status }}" aria-label="Default select example">
                        <option selected="" value="" disabled>pilih status</option>
                        @if (request()->status == 'checked')
                        <option value="checked" selected>checked</option>
                        <option value="not checked">not checked</option>
                        @elseif (request()->status == 'not checked')
                        <option value="checked">checked</option>
                        <option value="not checked" selected>not checked</option>
                        @elseif (request()->status == null)
                        <option value="checked">checked</option>
                        <option value="not checked">not checked</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <br>
                    <button class="btn btn-primary" type="submit"><i data-feather="search"></i></button>
                    <a href="/panic-button" class="btn btn-primary" type="button">Refresh</a>

                </div>
            </div>
        </form>
        </p>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">cluster</th>
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
                $no = 1;
                @endphp
                @foreach ($panic as $pan)
                <tr>
                    <th scope="row">{{ $no++ }}</th>

                    @if ($pan->properti)
                    <td>{{ $pan->properti->no_rumah}}</td>
                    <td>

                        @php
                        $cluster = \App\Models\Properti::with('cluster')->where('id', $pan->properti->id )->first();
                        @endphp
                        {{$cluster->cluster->name}}

                    </td>
                    @else
                    <td></td>
                    <td></td>
                    @endif

                    <td>{{ $pan->user->name }}</td>
                    <td>{{ $pan->keterangan }}</td>

                    <td>
                        @if ($pan->status_keterangan == 'checked')
                        <span class="badge bg-success">checked</span>
                        @else
                        <span class="badge bg-danger">not checked</span>
                        @endif
                    </td>

                    <div class="modal fade" id="exampleEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Alasan Pemanggilan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('panic.status', $pan->id) }}" method="POST">
                                        @csrf
                                        @method('patch')

                                        <input type="hidden" id="id_rumah2" name="id_rumah">
                                        <input type="hidden" id="panic_id2" name="id">

                                        <input type="hidden" id="user_id2" name="user_id">
                                        <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tambah Alasan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Alasan Pemanggilan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('panic.status', $pan->id) }}" method="POST">
                                        @csrf
                                        @method('patch')

                                        <input type="hidden" placeholder="rumah_id" id="id_rumah" name="id_rumah">
                                        <input type="hidden" placeholder="panic_id" id="panic_id" name="id">

                                        <input type="hidden" placeholder="user_id" id="user_id" name="user_id">
                                        <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tangani</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <td>{{ $pan->created_at }}</td>


                    <td>
                        <div class="d-flex">
                            <a class="mx-1 btn btn-primary fa-solid fa-edit" data-edit_id="{{ $pan->id }}" data-toggle="modal" data-target="#exampleEdit" data-placement="top" title="edit keterangan"></a>

                            @if ($pan->status_keterangan == 'not checked')
                            <a class="mx-1 btn btn-success" data-toggle="modal" data-riwayat_id="{{ $pan->id }}" data-keterangan="{{ $pan->keterangan }}" data-target="#exampleModal"><i class="fa-solid fa-check"></i></i></a>
                            @else

                            @endif
                        </div>


                    </td>

                </tr>
                @endforeach


            </tbody>
        </table>

        <!-- Modal -->

    </div>
</div>
@endsection

@push('before-style')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
@endpush

@push('after-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
<script>
    var APP_URL = {
        !!json_encode(url('/')) !!
    }
    console.log(APP_URL);
    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('riwayat_id')

        $.ajax({
            type: 'get',
            url: "/panic-button/detail/" + id,
            dataType: 'json',
            success: function(response) {
                // console.log(response);

                $('#user_id').val(response.user_id);
                $('#id_rumah').val(response.id_rumah);
                $('#panic_id').val(response.id);



            }
        });

    })
</script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    });
</script>

<script>
    var APP_URL = {
        !!json_encode(url('/')) !!
    }
    console.log(APP_URL);
    $('#exampleEdit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('edit_id')

        $.ajax({
            type: 'get',
            url: "/panic-button/edit/" + id,
            dataType: 'json',
            success: function(response) {
                console.log(response);

                $('#user_id2').val(response.user_id);
                $('#id_rumah2').val(response.id_rumah);
                $('#panic_id2').val(response.id);



            }
        });

    })
</script>
<script>
    var APP_URL = {
        !!json_encode(url('/')) !!
    }
    // console.log(APP_URL);

    function excel() {

        var fromDate = $('#from_date').val();
        // alert('halo');
        var toDate = $('#to_date').val();
        var status = $('#status').val();
        // console.log(status);
        if (status == null) {
            window.open(`${APP_URL}/panic-button/export_excel?start_date=${fromDate}&end_date=${toDate}`)
        }
        window.open(`${APP_URL}/panic-button/export_excel?start_date=${fromDate}&end_date=${toDate}&status=${status}`)
    }
</script>
@endpush