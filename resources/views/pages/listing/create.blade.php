@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Listing</h5>
            {{-- <p class="card-description">Listing yang telah ditambahkan akan muncul di halaman listing</p> --}}
            <form action="{{ route('listing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="form-label">Judul Listing</label>
                        <input value="{{ old('name') }}" type="text" required class="form-control" name="name"
                            aria-label="First name">
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Masukkan Gambar</label>
                        <input id="filePhoto" required type="file" class="form-control" name="image" placeholder="address">
                        <img id="output" src="" alt="" width="300">
                    </div>
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Tujuan Listing</label>
                        <select class="form-select" id="select_tujuan" onchange="selectTujuan(this.value)" name="status"
                            aria-label="Default select example">
                            <option disabled selected="">Pilih Tujuan Listing</option>
                            <option value="disewakan">disewakan</option>
                            <option value="dijual">dijual</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="periode">
                        <div class="form-group">
                            <label for="">Periode</label>


                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="basic-addon2" name="periode">
                                <span class="input-group-text" id="basic-addon2">tahun</span>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row mt-3">

                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Harga</label>

                        <input value="{{ old('harga') }}" id="harga" type="text" required class="form-control money"
                            id="harga" onkeyup="onchange_comma(this.id, this.value); count();" name="harga">
                    </div>

                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Diskon</label>
                        <div class="input-group">
                            <input value="{{ old('diskon') }}" required id="diskon" type="number" min="0" required
                                name="diskon" class="form-control" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" onkeyup="count()">
                            <span class="input-group-text" id="basic-addon2">%</span>
                            <p class="text-warning">isi 0 apabila tidak ada diskon</p>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Setelah Diskon</label>
                        <div class="input-group">
                            <input id="setelahDiskon" readonly type="text" min="0" required class="form-control"
                                aria-label="Recipient's username" aria-describedby="basic-addon2" name="setelah_diskon">
                            {{-- <span class="input-group-text" id="basic-addon2">%</span> --}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for=" " class="form-label">Pilih Cluster</label>
                        <select class="form-select" name="cluster_id" id="cluster">
                            <option hidden>Pilih Cluster</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-3">
                        <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                        <select class="form-select" name="properti_id" id="no_rmh">
                            <option value="" selected disabled>Pilih No Rumah</option>
                        </select>
                    </div>




                </div>


                <div class="row mt-1">
                    <div class="col">
                        <label class="form-label" for="">Deskripsi</label>
                        {{-- <textarea class="form-control" id="post" rows="12"  name="desc" aria-label="With textarea"></textarea> --}}
                        <textarea id="konten" class="form-control" name="desc" rows="10" cols="50"></textarea>

                    </div>

                </div>

                <div class="row mt-3 mb-5" id="dataProperti">

                </div>


                    <a href="{{ route('listing') }}" class="btn btn-warning ">kembali</a>
                    <button type="submit" class="btn btn-primary ml-4 ">Simpan</a>

            </form>

        </div>
    </div>
@endsection

@push('after-script')
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".realprocode").remove();
            });
        });
    </script> --}}


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script>
   var konten = document.getElementById("konten");
     CKEDITOR.replace(konten,{
     language:'en-gb'
   });
   CKEDITOR.config.allowedContent = true;
</script>
    {{-- <script>
        var harga = parseFloat($("#harga").val());
        console.log(harga);
        var diskon = parseFloat($("#diskon").val());
        var hargaDiskon = harga * diskon / 100;
        var hargaAkhir = harga - hargaDiskon;

        $("#setelahDiskon").val(parseFloat(hargaAkhir));

    </script> --}}
    <script>
        function selectTujuan(val) {
            if (val == 'dijual') {
                $("#periode").hide();
            } else {
                $("#periode").show();
            }
        }
    </script>
    <script>
        function count() {
            var harga = $("#harga").val();
            harga = harga.replace(/\,/g, ''); // 1125, but a string, so convert it to number
            harga = parseInt(harga, 10);

            var diskon = $("#diskon").val();
            diskon = diskon.replace(/\,/g, ''); // 1125, but a string, so convert it to number
            diskon = parseInt(diskon, 10);
            // console.log(harga);
            // var diskon = ($("#diskon").val());
            var hargaDiskon = harga * diskon / 100;
            var hargaAkhir = harga - hargaDiskon;

            // $("#setelahDiskon").val(hargaAkhir).toLocaleString('en'));

            var jumlah = numberWithCommas(hargaAkhir);
            // alert(jumlah);
            $("#setelahDiskon").val(jumlah);
            // alert(harga);
        }

        function numberWithCommas(x) {
            return (Math.round(x * 100) / 100).toLocaleString();
        }
    </script>

    <script>
        $("#periode").hide();

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
                            $('#no_rmh').html(data);
                            $('#no_rmh').trigger('change');
                        }
                    });
                } else {
                    $('#no_rmh').empty();
                }
            });

            $('#no_rmh').on('change', function() {
                var properti_id = $(this).val();
                var text1 = "";
                if (properti_id) {
                    $.ajax({
                        url: '/listing/properti/' + properti_id,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
                            // $('#jumlah').val(data);
                            text1 += ` <div class="col-md-10">
                                                <div id="content-loader">
                                                    <table class="table" id="myTable">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Alamat</th>
                                                                <th scope="col">No Rumah</th>
                                                                <th scope="col">RT</th>
                                                                <th scope="col">RW</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td>${data.alamat}</td>
                                                            <td>${data.no_rumah}</td>
                                                            <td>${data.RT}</td>
                                                            <td>${data.RW}</td>

                                                        </tbody>
                                                    </table>
                                            </div> `;
                            $("#dataProperti").html(text1);
                        }


                    });
                } else {
                    $('#jumlah').val('');
                }
            });

        });





        $(function() {
            $("#filePhoto").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output").attr("src", x);
                console.log(event);
            });
        });
        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })

            $('.multiple2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
            })
            // alert('halo');
        })

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
        }
    </script>
@endpush

@push('before-style')
    <style>
        .form-label {
            font-weight: 500;
        }

    </style>
@endpush
