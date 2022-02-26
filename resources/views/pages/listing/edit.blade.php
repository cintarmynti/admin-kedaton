@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Properti Listing</h5>
        <p class="card-description">Properti yang telah diedit akan muncul di halaman properti</p>
        <form action="{{route('listing.update', $listing->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-4">
                    <label for="formGroupExampleInput" class="form-label">Judul Listing</label>
                    <input value="{{ old('name', $listing->name) }}" type="text" required class="form-control" name="name"
                        aria-label="First name">
                </div>
                <div class="col-md-5">
                    <label for="" class="form-label">Masukkan Gambar</label>
                    <input id="filePhoto" type="file" class="form-control" name="image" placeholder="address">
                    <img class="mt-3" id="output" src="{{ asset('storage/' . $listing->image ) }}" style="max-width: 200px; max-height:200px" >
                </div>


            </div>


            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="formGroupExampleInput" class="form-label">Pilih Tujuan Listing</label>

                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Pilih Status Kepemilikan</option>
                        @if ($listing->status = 'desewakan')
                        <option value="disewakan" selected>disewakan</option>
                        <option value="dijual">dijual</option>
                        @elseif($listing->status = 'dijual')
                        <option value="disewakan" >disewakan</option>
                        <option value="dijual" selected>dijual</option>
                        @endif
                        <option value="disewakan">disewakan</option>
                        <option value="dijual">dijual</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">Pilih Cluster</label>
                    <select class="form-select" name="cluster_id" id="cluster">
                        <option hidden>Pilih Cluster</option>
                        @foreach ($cluster as $item)
                            <option value="{{ $item->id }}" {{$item->id == $listing->cluster_id ? 'selected' : ''}}>{{ $item->name }}</option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-3">
                    <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                    <select class="form-select" name="properti_id" id="no_rmh">
                        <option value="{{$listing->properti_id}}" selected >{{$listing->properti->no_rumah}}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Periode</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{$listing->periode}}"  aria-describedby="basic-addon2" name="periode">
                            <span class="input-group-text" id="basic-addon2">tahun</span>
                        </div>

                    </div>
                </div>
            </div>



            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="formGroupExampleInput" class="form-label">Harga</label>

                    <input value="{{ old('harga', $listing->harga) }}" onkeyup="onchange_comma(this.id, this.value); count();" type="text" required class="form-control money" id="harga"
                        name="harga">
                </div>

                <div class="col-md-3">
                    <label for="formGroupExampleInput" class="form-label">Diskon</label>
                    <div class="input-group">
                        <input value="{{ old('diskon', $listing->diskon) }}" id="diskon" type="number" min="0" required name="diskon"
                        class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2"
                        onkeyup="count()">
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="formGroupExampleInput" class="form-label">Setelah Diskon</label>
                    <div class="input-group">
                        <input id="setelahDiskon" value="{{ old('diskon', $listing->setelah_diskon) }}" type="number" readonly  min="0" required class="form-control" name="setelah_diskon"
                         aria-label="Recipient's username" aria-describedby="basic-addon2">
                        {{-- <span class="input-group-text" id="basic-addon2">%</span> --}}
                    </div>
                </div>
            </div>


            <a href="{{ route('listing') }}" class="btn btn-warning mt-4">kembali</a>
            <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>

        </form>

    </div>
</div>
@endsection

@push('after-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

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

            $("#setelahDiskon").val(parseInt(hargaAkhir));
            // alert(harga);
        }
</script>
    <script>
        $(function() {
            $("#filePhoto").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output").attr("src", x);
                console.log(event);
            });
        });
        function image() {
            const viewer = new Viewer(document.getElementById('images'), {
                viewed() {
                    viewer.zoomTo(1);
                },
            });
        }
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
                        $('#no_rmh').html(data);
                        $('#no_rmh').trigger('change');
                    }
                });
            } else {
                $('#no_rmh').empty();
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



</script>
@endpush

@push('before-style')
    <style>
        .wrapper {
            text-align: center;
           display: flex;
           flex-direction: column;
        }

        .panjang{
            width:200px;
        }

    </style>
@endpush
