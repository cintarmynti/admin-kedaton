@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Penghuni</h5>
            {{-- <a type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                Tooltip on top
            </a> --}}
            <p class="card-description">
                <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah Penghuni dan Properti</a>
                <a href="/user/export_excel" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
            </p>
            <div class="table-responsive">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        {{-- user id --}}
                        <th scope="col">Nama</th>
                        <th scope="col">nik</th>
                        <th scope="col">Properti</th>
                        <th scope="col">Tanggal Masuk</th>
                        {{-- <th scope="col">Total Properti</th> --}}
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
                            <td>{{ $user->name }}
                                @if ($user->snk == 1)
                                    <i class="fa-solid fa-mobile fa-2x" style="color: #6BCAC2" data-toggle="tooltip"
                                        data-placement="top" title="pengguna mobile"></i>
                                @else
                                @endif




                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Setujui Pendaftaran
                                                    Penghuni Ini</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- setujui penghuni user ini --}}

                                                <h4>Data Pendaftar</h4>
                                                <table class="table">
                                                    <tr>
                                                        <td>Didaftarkan Oleh : </td>
                                                        <td>
                                                            <p id="nama_pemilik"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>nama : </td>
                                                        <td>
                                                            <p id="nama_penghuni"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>email : </td>
                                                        <td>
                                                            <p id="email"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>nik : </td>
                                                        <td>
                                                            <p id="nik"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>alamat : </td>
                                                        <td>
                                                            <p id="alamat"></p>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>phone : </td>
                                                        <td>
                                                            <p id="phone"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>foto KTP :</td>

                                                        <td><img width="200px" src="" id="user_img" alt=""> </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>foto identitas :</td>
                                                        <td><img width="200px" src="" id="user_identity_img" alt=""> </td>
                                                    </tr> --}}


                                                    {{-- <tr>
                                        <td>photo ktp : </td>
                                        <td></td>
                                    </tr> --}}
                                                </table>
                                                <form action="/user/user-cancel">
                                                    @csrf
                                                    @method('patch')
                                                    <h5>Alasan Penolakan(di isi apabila pengajuan ditolak)</h5>
                                                    <textarea class="form-control" name="alasan_dibatalkan" required aria-label="With textarea"></textarea>
                                                    <input type="hidden" id="input_penghuni2" name="penghuni_id2">
                                                    <input type="hidden" id="input_pemilik2" name="pemilik_id2">
                                                </div>
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Tolak</button>

                                                </form>
                                                <form action="/user/user-activated" method="post">
                                                    @csrf
                                                    @method('patch')

                                                    <input type="hidden" id="input_penghuni" name="penghuni_id">
                                                    <input type="hidden" id="input_pemilik" name="pemilik_id">
                                                    <button type="submit" class="btn btn-success">Setujui</button>
                                                    {{-- <a href="" >Setujui</a> --}}
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </td>
                            <td>{{ $user->nik }}</td>
                            @if ($user->pemilik->count() != 0)
                                <td><?php if ($user->penghuni->count() != 0) {
                                    $milik = [];
                                    foreach ($user->pemilik as $key) {
                                        array_push($milik, $key->id);
                                    }
                                    foreach ($user->penghuni as $key) {
                                        $id = $key->id;
                                        if (!in_array($id, $milik)) {
                                            array_push($milik, $id);
                                        }
                                    }
                                    echo count($milik) . ' Unit';
                                } else {
                                    echo $user->pemilik->count() . ' Unit';
                                }
                                ?></td>
                            @else
                                <td>{{ $user->penghuni->count() }} Unit</td>
                            @endif
                            <td>{{ $user->created_at }}</td>

                            {{-- <td>

                            </td> --}}
                            {{-- <td>{{$user->status_penghuni}}</td> --}}
                            {{-- <td>{{ $user->alamat }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if ($user->photo_identitas != null)
                        <img src="{{ asset('storage/' . $user->photo_identitas) }}" id="image" onclick="image()" style="height: 100px; width:150px; object-fit:cover" alt="">
                        @endif
                    </td> --}}
                            {{-- <td><a href="/user/detail/{{ $user->id }}">lihat detail</a></td> --}}
                            <td>
                                <div class="d-flex">
                                    {{-- <a class="mx-1" href="{{ route('user.edit', $user->id) }}"><i data-feather="edit"></i></a> --}}

                                    {{-- <button type="submit" class="mx-1 btn-danger delete" data-id="{{ $user->id }}"
                            data-nama="">
                            <i data-feather="trash"></i>
                            </button> --}}

                                    {{-- <a class="mx-1" href="{{ route('user.profile', $user->id) }}"><i data-feather="user"></i></a> --}}
                                    {{-- <a type="button" class="btn btn-primary fa-solid fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">

                                            </a> --}}
                                    <a class="mx-1 btn btn-primary fa-solid fa-eye" type="button"
                                        href="{{ route('user.detail', $user->id) }}" data-toggle="tooltip"
                                        data-placement="top" title="detail user"></a>
                                    <a class="mx-1 btn btn-primary" type="button"
                                        href="{{ route('user.newProp', $user->id) }}" data-toggle="tooltip"
                                        data-placement="top" title="Tambah Properti"><i class="fa-solid fa-house"></i></a>
                                    @if ($user->email_pengajuan == 1)
                                        <a class="mx-1 btn btn-warning" href="" data-bs-toggle="modal" data-penghuni_id="{{ $user->id }}"
                                            data-bs-target="#exampleModal"><i class="fa-solid fa-user-check"
                                                 data-toggle="tooltip" data-placement="top"
                                                title="permintaan persetujuan"></i></a>
                                    @elseif ($user->email_pengajuan == 2)
                                    @endif
                                </div>
                                {{-- <div class="d-flex">
                            <a class="mx-1 btn btn-success"  href="{{route('user.activated', $user->id)}}" data-toggle="tooltip" data-placement="top" title="Kirim Email">
                                <i class="fa-solid fa-check"></i>

                            </a>

                            <a class="mx-1 btn btn-danger"  href="{{route('user.activated', $user->id)}}" data-toggle="tooltip" data-placement="top" title="Kirim Email">
                                <i class="fa-solid fa-xmark"></i>

                            </a>
                        </div> --}}

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
@endpush

@push('before-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootsrap/bootsrap5/css/bootstrap.min.css')}}">
@endpush

@push('after-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script>
         var APP_URL = {!! json_encode(url('/')) !!}
        $(document).ready(function() {
            $('#myTable').DataTable();
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        });

        $('#exampleModal').on('show.bs.modal', function(event) {
            console.log('halo');
            var button = $(event.relatedTarget)
            var id = button.data('penghuni_id')

            $.ajax({
                type: 'get',
                url: "/user/detail_penghuni/" + id,
                dataType: 'json',
                success: function(response) {
                    // console.log(response.user.photo_ktp);

                    // $("#stat").val(response.status)
                    // $('#user_id').val(response.id);
                    // $('#id_rumah').val(response.id_rumah);
                    // $('#panic_id').val(response.id);

                    // $('#user_identity_img').attr('src', response.user.photo_identitas);
                    $('#user_img').attr('src', response.user.photo_ktp);
                    $('#nama_pemilik').html(response.user_pemilik.name);
                    $('#nama_penghuni').html(response.user.name);
                    $('#email').html(response.user.email);
                    $('#nik').html(response.user.nik);
                    $('#alamat').html(response.user.alamat);
                    $('#phone').html(response.user.phone);
                    $('#input_penghuni2').val(response.user.id);
                    $('#input_pemilik2').val(response.user_pemilik.id);
                    $('#input_penghuni').val(response.user.id);
                    $('#input_pemilik').val(response.user_pemilik.id);
                    $('#halo').html(response.user.photo_ktp);


                }
            });

        })


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
