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

                            <label for="">No Rumah</label>
                            <select class="form-select no-rumah" onchange="myFunction($(this))" name="rumah_id" aria-label="Default select example">
                                <option disabled selected="">Pilih No Rumah</option>
                                @foreach($nomer as $no)
                                <option value="{{ $no->id }}" data-tarif={{$no -> tarif_ipkl}}>{{ $no->no_rumah }}</option>
                                @endforeach
                              </select>
                        </div>
                        {{-- <label for="formGroupExampleInput" class="form-label">No Rumah</label>
                        <input type="text" required class="form-control" name="rumah_id"
                            aria-label="First name"> --}}

                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Periode Pembayaran</label>
                        <input type="date" required class="form-control tarif-input"  name="periode_pembayaran"
                            aria-label="Last name">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">

                        <label for="">Metode Pembayaran</label>
                        <select class="form-select" name="metode_pembayaran" aria-label="Default select example">
                            <option disabled selected="">Pilih Metode Pembayaran</option>
                            <option value="transfer">transfer</option>
                            <option value="cash">cash</option>
                          </select>
                    </div>

                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Jumlah Pembayaran</label>
                        <input id="myText" type="text" id="jumlah" onkeyup="onchange_comma(this.id, this.value)" required class="form-control" name="jumlah_pembayaran"
                            aria-label="Last name">
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

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
        }

        function myFunction(e) {
            // console.log(data.tarif);
            document.getElementById("myText").value = $(e).find('option:selected').data('tarif');

        }

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
