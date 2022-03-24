@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Daftar Listing</h5>
        <p class="card-description">
            <a class="btn btn-primary" href="{{ route('listing.create') }}">Tambah Listing</a>
            <a href="/listing/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
        </p>
        <div class="table-responsive">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">name</th>
                    <th scope="col">status</th>
                    <!-- <th scope="col">periode</th> -->
                    <th scope="col">harga</th>
                    <th scope="col">diskon</th>
                    <th scope="col">setelah diskon</th>
                    <th scope="col">detail bangunan</th>
                    <th scope="col">aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp
                @foreach ($listing as $p)

                <tr>
                    <th scope="row">{{ $no++ }}</th>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->status }}</td>
                    <!-- <td>{{$p->periode ? $p->periode : "-" }}</td> -->
                    <td>Rp.{{$p->harga}}</td>
                    <td>{{ $p->diskon ?  $p->diskon ."%"  : 'Tidak ada diskon'}}

                    </td>

                    <td>Rp.{{ $p->setelah_diskon }} {{$p->periode ? "/ " . $p->periode . " Tahun" : "-" }}</td>
                    <td><a href="{{ route('listing.detail', $p->properti_id) }}">lihat detail</a></td>
                    <td class="d-flex">
                        <a href="{{ route('listing.edit', $p->id) }}" class="btn btn-warning fa-regular fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="edit listing"></a>

                        {{-- <button type="submit" class="btn btn-danger delete fa-solid fa-trash-can" data-id="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="delete listing"></button> --}}

                    </td>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
<link rel="stylesheet" href="{{asset('assets/plugins/bootsrap/bootsrap5/css/bootstrap.min.css')}}">
@endpush

@push('after-script')
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"> --}}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
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
                    window.location = "/listing/delete/" + userId;
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
