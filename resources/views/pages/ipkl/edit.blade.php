@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Pembayaran IPKL</h5>
            <p class="card-description">IPKL yang telah ditambahkan akan muncul di halaman IPKL</p>
            <form action="{{ route('ipkl.update', $ipkl->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">No Rumah</label>
                        <input type="text" value="{{old('rumah_id', $ipkl->rumah_id)}}" required class="form-control" name="rumah_id"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Periode Pembayaran</label>
                        <input type="text" value="{{old('periode_pembayaran', $ipkl->periode_pembayaran)}}" required class="form-control" name="periode_pembayaran"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Metode Pembayaran</label>
                        <input type="text" value="{{old('periode_pembayaran', $ipkl->metode_pembayaran)}}" required class="form-control" name="metode_pembayaran"
                            aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Pembayaran</label>
                        <input type="text" required class="form-control" value="{{old('periode_pembayaran', $ipkl->jumlah_pembayaran)}}" name="jumlah_pembayaran"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">status</label>
                        <input type="text" value="{{old('status', $ipkl->status)}}" required class="form-control" name="status"
                            aria-label="First name">
                    </div>

                </div>


                <a href="{{ route('ipkl') }}" class="btn btn-warning mt-4">kembali</a>
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
                // placeholder: 'Select Cluster',
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

@push('before-style')
    <style>
        .form-label{
            font-weight: 500;
        }
    </style>
@endpush
