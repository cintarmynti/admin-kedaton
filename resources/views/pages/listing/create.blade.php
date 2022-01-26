@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Listing</h5>
            <p class="card-description">Listing yang telah ditambahkan akan muncul di halaman listing</p>
            <form action="{{ route('listing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Alamat</label>
                        <input type="text" required class="form-control" name="alamat" placeholder="Alamat"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">No Rumah</label>
                        <input type="text" required class="form-control" name="no" placeholder="No Rumah"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">RT</label>
                        <input type="text" required class="form-control" name="RT" placeholder="RT"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">RW</label>
                        <input type="text" required class="form-control" name="RW" placeholder="RW"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Lantai</label>
                        <input type="text" required class="form-control" name="lantai" placeholder="Lantai"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Kamar</label>
                        <input type="text" required class="form-control" name="jumlah_kamar" placeholder="Jumlah kamar"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Luas Kavling</label>
                        <div class="input-group mb-3">
                            <input type="number" min="0" required name="luas_tanah" placeholder="luas kavling"
                                class="form-control" placeholder="Recipient's username" aria-label="Recipient's username"
                                aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">m2</span>
                        </div>
                    </div>


                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Luas Bangunan</label>
                        <div class="input-group mb-3">
                            <input type="number" min="0" required name="luas_bangunan" placeholder="luas bangunan"
                                class="form-control" placeholder="Recipient's username" aria-label="Recipient's username"
                                aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">m2</span>
                        </div>

                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Penghuni</label>
                        <select class="form-select" name="penghuni" aria-label="Default select example">
                            <option disabled selected="">penghuni</option>
                            @foreach ($user as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Pemilik</label>
                        <select class="form-select" name="pemilik" aria-label="Default select example">
                            <option disabled selected="">pemilik</option>
                            @foreach ($user as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Status Kepemilikan</label>

                        <select class="form-select" name="status" aria-label="Default select example">
                            <option disabled selected="">Status Kepemilikan</option>
                            <option value="dihuni">dihuni</option>
                            <option value="disewakan">disewakan</option>
                            <option value="dijual">dijual</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Harga</label>

                        <input type="text" required class="form-control money" id="harga" onkeyup="onchange_comma(this.id, this.value)" name="harga" placeholder="harga(optional)">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="formGroupExampleInput" class="form-label">Pilih Cluster</label>

                        <select id="category" class="form-control select2" name="cluster_id"
                            aria-label="Default select example">
                            <option disabled selected="">Pilih Cluster</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                    </div>

                </div>



                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="formGroupExampleInput" class="form-label">Masukkan Gambar</label>
                        <div class="input-group realprocode control-group lst increment">
                            <input type="file" name="image[]" class="myfrm form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success" type="button"> <i
                                        class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                            </div>
                        </div>
                        <div class="clone hide">
                            <div class="realprocode control-group lst input-group" style="margin-top:10px">
                                <input type="file" name="image[]" class="myfrm form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger" type="button"><i
                                            class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                </div>
                            </div>
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
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })

            // alert('halo');
        })

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
        }

    </script>


@endpush
