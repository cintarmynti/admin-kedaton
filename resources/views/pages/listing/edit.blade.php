@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Properti</h5>
        <p class="card-description">Properti yang telah diedit akan muncul di halaman properti</p>
        <form action="{{route('listing.update', $listing->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                    <input value="{{ old('name', $listing->name) }}" type="text" required class="form-control" name="name"
                        aria-label="First name">
                </div>
                <div class="col">
                    <label for="" class="form-label">Masukkan Gambar</label>
                    <input id="filePhoto" type="file" class="form-control" name="image" placeholder="address">
                    <img class="mt-3" id="output" src="{{ asset('storage/' . $listing->image ) }}" style="max-width: 100px; max-height:100px" >
                </div>
            </div>


            <div class="row mt-4">

                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Properti</label>
                    <select class="form-select multiple2" name="properti_id" aria-label="Default select example">
                        <option disabled selected="">Pilih Properti</option>
                        @foreach ($properti as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $listing->properti_id ? 'selected' : '' }}>{{ $p->alamat }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Status Kepemilikan</label>

                    <select class="form-select" name="status" aria-label="Default select example">
                        <option disabled selected="">Pilih Status Kepemilikan</option>
                        <option value="dihuni" {{ "dihuni" == $listing->status ? 'selected' : '' }}>dihuni</option>
                        <option value="disewakan" {{ "disewakan" == $listing->status ? 'selected' : '' }}>disewakan</option>
                        <option value="dijual" {{ "dijual" == $listing->status ? 'selected' : '' }}>dijual</option>
                    </select>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label">Harga</label>

                    <input value="{{ old('harga', $listing->harga) }}" type="text" required class="form-control money"
                     id="harga" onkeyup="onchange_comma(this.id, this.value)" name="harga">
                </div>

                <div class="col-md-4">
                    <label for="formGroupExampleInput" class="form-label">Diskon</label>
                    <div class="input-group mb-3">
                        <input value="{{ old('diskon', $listing->diskon) }}" type="number" min="0" required name="diskon"
                            class="form-control"  aria-label="Recipient's username"
                            aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">%</span>
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
