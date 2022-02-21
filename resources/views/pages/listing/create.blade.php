@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Listing</h5>
            {{-- <p class="card-description">Listing yang telah ditambahkan akan muncul di halaman listing</p> --}}
            <form action="{{ route('listing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <label for="formGroupExampleInput" class="form-label">Name</label>
                        <input value="{{ old('name') }}" type="text" required class="form-control" name="name"
                            aria-label="First name">
                    </div>
                    <div class="col-md-5">
                        <label for="formGroupExampleInput" class="form-label">Harga</label>

                        <input value="{{ old('harga') }}" type="text" required class="form-control money" id="harga"
                            onkeyup="onchange_comma(this.id, this.value)" name="harga">
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="">Pilih Cluster</label>
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
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Status Kepemilikan</label>

                        <select class="form-select" name="status" aria-label="Default select example">
                            <option disabled selected="">Pilih Status Kepemilikan</option>
                            <option value="disewakan">disewakan</option>
                            <option value="dijual">dijual</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">


                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Diskon</label>
                        <div class="input-group">
                            <input value="{{ old('diskon') }}" type="number" min="0" required name="diskon"
                                class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="" class="form-label">Masukkan Gambar</label>
                        <input id="filePhoto" required type="file" class="form-control" name="image" placeholder="address">
                        <img id="output" src="" alt="" width="300">
                    </div>

                </div>



                <a href="{{ route('listing') }}" class="btn btn-warning mt-3">kembali</a>
                <button type="submit" class="btn btn-primary ml-4 mt-3">Simpan</a>

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
