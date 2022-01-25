@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Listing</h5>
            <p class="card-description">Listing yang telah ditambahkan muncul di halaman listing</p>
            <form action="{{ route('listing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="text" required class="form-control" name="alamat" placeholder="alamat"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <input type="text" required class="form-control" name="no" placeholder="no" aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <input type="text" required class="form-control" name="RT" placeholder="RT"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <input type="text" required class="form-control" name="RW" placeholder="RW"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <input type="text" required class="form-control" name="lantai" placeholder="lantai"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <input type="text" required class="form-control" name="jumlah_kamar" placeholder="jumlah kamar"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <input type="text" required class="form-control" name="luas_tanah" placeholder="luas kavling"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <input type="text" required class="form-control" name="luas_bangunan" placeholder="luas bangunan"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <select class="form-select" name="penghuni" aria-label="Default select example">
                            <option disabled selected="">penghuni</option>
                            @foreach ($user as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col">
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
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option disabled selected="">Status Kepemilikan</option>
                            <option value="dihuni">dihuni</option>
                            <option value="disewakan">disewakan</option>
                            <option value="dijual">dijual</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" required class="form-control" name="harga" placeholder="harga(optional)"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })
        })
    </script>
@endpush
