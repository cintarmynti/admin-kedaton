@extends('layouts.default')


@section('content')
<div class="row">
    <div id="box-alert" class="row">
        {{-- @if ($total == 0)

        @else
        <div class="col-md-12  mb-3">
            Ingin menangani semuanya ?
            <b style="cursor: pointer;"><a class="text-danger" href="/panic-button/dashboard-all">Tangani Semua</a></b>
        </div>

        @endif --}}
    </div>

    <!-- <div id="panic-button" class="row">

    </div> -->

    <div class="row" id="panic-button">

        @forelse($panic as $p)
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card card-panic">
                <div class="card-body">
                    <h6>Butuh Penanganan</h6>
                    <h1>{{$p->name}}-{{$p->no_rumah}}</h1>
                    <hr>
                    <a data-bs-toggle="modal" data-bs-target="#ketPanicModal" data-panic_id="{{$p->id}}" class="btn btn-block btn-md btn-danger">TANGANI</a>
                </div>
            </div>
        </div>


        <div class="modal fade" id="ketPanicModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Alasan Panic Button</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panic.status', $p->id) }}" method="POST">
                    @csrf
                    @method('patch')

                    <input type="hidden" placeholder="rumah_id" id="id_rumah" name="id_rumah">
                    <input type="hidden" placeholder="panic_id" id="panic_id" name="id">

                    <input type="hidden" placeholder="user_id" id="user_id" name="user_id">
                    <input type="text" class="form-control" placeholder="Keterangan" name="keterangan">
              {{-- Woohoo, you're reading this text in a modal! --}}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </form>

            </div>
          </div>
        </div>
      </div>

        @empty

        @endforelse
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-widget">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Pengguna</h5>
                    <h2>{{ $customer }}</h2>
                    <p><a href="{{route('user')}}">pengguna</a> </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-widget">
                <div class="card-body">
                    <h5 class="card-title">Listing disewakan</h5>
                    <h2>{{ $disewakan }}</h2>
                    <p><a href="{{route('listing')}}">listing</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-widget">
                <div class="card-body">
                    <h5 class="card-title">Listing dijual</h5>
                    <h2>{{ $dijual }}</h2>
                    <p><a href="{{route('listing')}}">listing</a></p>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-widget">
                <div class="card-body">
                    <h5 class="card-title">Complain</h5>
                    <h2>{{ $complain }}</h2>
                    <p><a href="{{route('complain')}}">Complain</a></p>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div id="blink">
            TES TES ​
        </div> --}}
    </div>

    @endsection

    @push('before-style')
    <style>
        @keyframes blinking {
            0% {
                background-color: #e53935;
                border: 3px solid #e53935;
                color: white
            }

            100% {
                background-color: white;
                border: 3px solid #e53935;
                color: #e53935
            }
        }

        #blink {
            width: 200px;
            height: 200px;
            animation: blinking 1s infinite;
        }
    </style>
    @endpush

    @push('after-script')
        <script>
             $('#ketPanicModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('panic_id')

        $.ajax({
            type: 'get',
            url: "/panic-button/detail/" + id,
            dataType: 'json',
            success: function(response) {
                console.log(response.id_rumah);

                $('#user_id').val(response.user_id);
                $('#id_rumah').val(response.id_rumah);
                $('#panic_id').val(response.id);



            }
        });

    })
        </script>
    @endpush

