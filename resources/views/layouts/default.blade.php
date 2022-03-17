<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- untuk cluster --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


    {{-- summer note --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">




    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @stack('before-style')

    <!-- Title -->
    <title>Admin - Kedaton</title>

    <audio id="chat-alert-sound" loop style="display: none">
        <source src="{{ asset('assets/notif.mp3') }}" type="audio/mpeg" />
    </audio>

    <audio id="tinung-sound" style="display: none">
        <source src="{{ asset('assets/tinung.mp3') }}" type="audio/mpeg" />
    </audio>
    <!-- Styles -->
    @include('includes.style')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>

    <div class="page-container">
        <div class="page-header">
            {{-- navbar --}}
            @include('includes.navbar')
        </div>
        {{-- sidebar --}}
        @include('includes.sidebar')
        <div class="page-content">
            <div class="main-wrapper">
                {{-- content --}}
                @yield('content')
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alasan Panic Button</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('panic.status') }}" method="POST">
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


    {{-- <script>
        let channel = pusher.subscribe('warning');
    </script> --}}
    {{-- <input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" /> --}}
    <input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
    <input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />

    <!-- Javascripts -->
    @include('includes.script')
    @include('sweetalert::alert')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('panic_id')

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
        let pusher = new Pusher($("#pusher_app_key").val(), {
            cluster: $("#pusher_cluster").val(),
            encrypted: true
        });
        let complain = pusher.subscribe('admin');
        let channel = pusher.subscribe('chat');
        let addPenghuni = pusher.subscribe('add_penghuni_prop');
        let properti = pusher.subscribe('add_new_properti');
        //ini buat all notif

        channel.bind('send', function(data) {
            let alert_sound = document.getElementById("chat-alert-sound");
            alert_sound.play();
            // console.log(data);
            // console.log('halo');
            // console.log(notif_panic);

            alert_button();

        })

        function alert_button() {
            $.ajax({
                type: "get",
                url: "/panic-button/belum_dicek",
                data: "data",
                dataType: "json",
                success: function(response) {
                    // console.log(response);

                    var text = "";
                    $.each(response, function(i, item) {
                        // console.log(item.id);
                        text += `<div class="col-md-6 col-xl-3 mb-3">
                        <div class="card card-panic">
                            <div class="card-body">
                                <h6>Butuh Penanganan</h6>
                                <h1>${item.properti.no_rumah} - ${item.properti.cluster.name}</h1>
                                <hr>
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-panic_id="${item.id}" class="btn btn-block btn-md btn-danger">TANGANI</a>
                            </div>
                        </div>
                    </div>`

                    });

                    $("#panic-button").html(text);
                }
            });
        }

        //ini buat complain

        complain.bind('kirim', function(data) {
            // console.log(data);
            let sound = document.getElementById("tinung-sound");
            sound.play();

            getNotifAll()
        })

        //ini buat add properti

        properti.bind('new_prop', function(data) {
            // console.log(data);
            let sound = document.getElementById("tinung-sound");
            sound.play();
            getNotifAll()


        })

        //add penghuni prop
        addPenghuni.bind('penghuni_prop', function(data) {
            let sound = document.getElementById("tinung-sound");
            sound.play();
            getNotifAll()
        })
    </script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.css"
        integrity="sha512-r+5gXtPk5M2lBWiI+/ITUncUNNO15gvjjVNVadv9qSd3/dsFZdpYuVu4O2yELRwSZcxlsPKOrMaC7Ug3+rbOXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.js"
        integrity="sha512-taR40V17AK2+3RjqzCYkczb0/hTHuQCid0kBs0I2g6DqkFjkTcAIpsa+4PzGuWcRica2AOZQmz4pNPj4InFR8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>

    <script>
        $(document).ready(function() {
            // alert('halo');
            getNotifAll();
        });

        function getNotifAll() {
            $.ajax({
                type: "get",
                url: "/dashboard/notif-admin",
                data: "data",
                dataType: "json",
                success: function(response) {
                    if (response.jumlah != 0) {
                        $('#total-notif').html(response.jumlah);
                    } else {

                    }

                    var text = "";
                    $.each(response.data, function(i, item) {
                        // console.log(response.data);
                        // console.log(item.heading);
                        if (item.status_dibaca == 2) {
                            text += `<a href="/notif/${item.id}">
                            <div class="header-notif" >
                            <div class="notif-text" >
                                <p class="bold-notif-text" id="header-notif" style="text-transform:uppercase;">${item.heading}</p>
                                <small id="jam-notif">${item.jam_hari}</small>
                            </div>
                            </div>
                        </a>`;
                        } else {
                            text += `<a href="/notif/${item.id}">
                            <div class="header-notif" style="background-color:#f3f6f9;">
                            <div class="notif-text">
                                <p class="bold-notif-text" id="header-notif" style="text-transform:uppercase;">${item.heading}</p>
                                <small id="jam-notif">${item.jam_hari}</small>
                            </div>
                            </div>
                        </a>`;
                        }

                    })
                    $('#notif').html(text);

                }
            });
        }
    </script>

    {{-- <script src="{{ asset('js/chat.js') }}"></script> --}}
    @stack('after-script')
</body>

</html>
