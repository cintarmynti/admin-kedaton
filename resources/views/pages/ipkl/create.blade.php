@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Pembayaran IPKL</h5>
            <p class="card-description">IPKL yang telah ditambahkan akan muncul di halaman IPKL</p>
            <form action="{{ route('ipkl.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">

                        <label for="">Pilih Cluster</label>
                        <select class="form-select" required name="cluster_id" id="cluster">
                            <option hidden>Pilih Cluster</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                        <select class="form-select" required name="properti_id" id="no_rmh">
                            <option value="" selected disabled>Pilih No Rumah</option>
                        </select>
                        <p id="pesan" class="text-warning"></p>

                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="formGroupExampleInput" class="form-label">Periode Pembayaran</label>
                        <input type="date" required class="form-control date tarif-input date" id="datepicker"
                            name="periode_pembayaran" aria-label="Last name">
                        @if ($errors->any())
                            <p style="color: red">{{ $errors->first() }}</p>
                        @endif
                    </div>

                    <div class="col-md-6" id="harga">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Pembayaran</label>
                        <input type="text" id="jumlah" readonly required class="form-control" name="jumlah_pembayaran"
                            aria-label="Last name">
                    </div>

                    {{-- <div class="col-md-6">

                        <label for="">Metode Pembayaran</label>
                        <select class="form-select" name="metode_pembayaran" aria-label="Default select example">
                            <option disabled selected="">Pilih Metode Pembayaran</option>
                            <option value="transfer">transfer</option>
                            <option value="cash">cash</option>
                        </select>
                    </div> --}}
                </div>

                <div class="row mt-4">



                    {{-- <div class="col-md-6">
                        <label for="formGroupExampleInput" class="form-label">Masukkan Bukti Pembayaran</label>
                        <input  type="file" id="jumlah" readonly required
                            class="form-control" name="bukti_tf" aria-label="Last name">
                    </div> --}}
                </div>

                <a href="{{ route('ipkl') }}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>

        </div>




        </form>

    </div>
    </div>
@endsection

@push('after-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".realprocode").remove();
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script>
        function myFunction(e) {
            // console.log(data.tarif);
            document.getElementById("no_rmh").value = $(e).find('option:selected').data('tarif');

        }




        // $('.date').datepicker({
        //     format: 'mm-dd-yyyy'
        // });
    </script>

    <script>
        $(document).ready(function() {


            $('#cluster').on('change', function() {
                var clusterID = $(this).val();
                if (clusterID) {
                    $.ajax({
                        url: '/ipkl/cluster/' + clusterID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "html",
                        success: function(data) {
                            if (jQuery.isEmptyObject(data)) {
                            $('#pesan').html("tidk ada properti / properti tidak ada pemilik");
                        } else {
                            $('#no_rmh').html(data);
                            $('#no_rmh').trigger('change');
                            $('#pesan').html(" ");

                        }
                        }
                    });
                } else {
                    $('#no_rmh').empty();
                }
            });
        });


        $(document).ready(function() {
            function addCommas(str) {
                return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            $('#no_rmh').on('change', function() {
                var harga_id = $(this).val();
                if (harga_id) {
                    $.ajax({
                        url: '/ipkl/harga/' + harga_id,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "html",
                        success: function(data) {
                            // console.log(data);
                            $('#jumlah').val(addCommas(data));
                        }
                    });
                } else {
                    $('#jumlah').val('');
                }
            });
        });
    </script>
@endpush

@push('before-style')
    <style>
        .form-label {
            font-weight: 500;
        }

    </style>
@endpush

@push('after-script')
@endpush
