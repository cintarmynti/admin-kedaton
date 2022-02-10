@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Tagihan Layanan</h5>
            <p class="card-description">
                <a class="btn btn-primary" href="{{ route('layanan.create') }}">Tambah Tagihan</a>
            </p>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        {{-- user id --}}
                        <th scope="col">cluster id</th>
                        <th scope="col">no rumah</th>
                        <th scope="col">periode Pembayaran</th>
                        <th scope="col">jumlah pembayaran</th>
                        <th scope="col">status</th>
                        <th scope="col">aksi</th>

                    </tr>
                </thead>
                <tbody id="images">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($layanan as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->cluster->name }}</td>
                            <td>{{ $i->nomer->no_rumah }}</td>
                            <td>{{ $i->periode_pembayaran }}</td>
                            <td>{{ $i->jumlah_pembayaran }}</td>

                            <td><span
                                    class="badge @if ($i->status == 1)
                                        bg-warning
                                    @else
                                        bg-success
                                    @endif ">
                                    @if ($i->status == 1)
                                         pending
                                    @else
                                        sudah dibayar
                                    @endif
                                </span>
                            </td>
                            <td><a href="{{route('ipkl.pembayar', $i->id)}}">lihat</a></td>

                        </tr>
                    @endforeach


                </tbody>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/ipkl/riwayat-create" method="POST">
                                @csrf
                                @method('patch')
                                <img src="" width="400" height="300" id="bukti_tf" alt="">
                                <input type="text" name="tagihan_id" id="tagihan_id">
                                <input type="text" name="no_rumah" id="no_rumah">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('before-style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
@endpush

@push('after-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
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
        // console.log(APP_URL);



        function image() {

            const viewer = new Viewer(document.getElementById('images'), {
                viewed() {
                    viewer.zoomTo(1);
                },
            });
        }

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
                        window.location = "/ipkl/delete/" + userId;
                        swal("Data berhasil dihapus!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data anda batal dihapus!");
                    }
                });
        });
    </script>
    <script>
        var APP_URL = {!! json_encode(url('/')) !!}
        console.log(APP_URL);
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('riwayat_id')

            $.ajax({
                type: 'get',
                url: "/ipkl/riwayat/" + id,
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $('#tagihan_id').val(response.id);
                    $('#no_rumah').val(response.rumah_id);
                    $('#bukti_tf').attr('src', APP_URL + '/bukti_tf/' + response.bukti_tf);


                }
            });

        })
    </script>
@endpush

@push('before-style')

@endpush
