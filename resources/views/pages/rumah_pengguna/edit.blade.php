@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Rumah Pengguna</h5>
        <p class="card-description">Rumah Pengguna yang telah ditambahkan akan muncul di halaman rumah pengguna</p>
        <form action="/rumah-pengguna" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col mb-3">

                        <label for="">Pengguna</label>
                        <select class="form-select no-rumah" onchange="myFunction($(this))" name="name" aria-label="Default select example">
                            <option disabled selected="">Pilih Pengguna</option>
                            @foreach($nama as $no)
                            <option value="{{ $no->id }}" data-tarif={{$no -> name}}>{{ $no->name }}</option>
                            @endforeach
                          </select>
                        
                    </div>
                    <div class="row">
                        <div class="col">
    
                            <label for="">Pilih Cluster</label>
                            <select class="form-select" name="cluster_id" id="cluster">
                                <option hidden>Pilih Cluster</option>
                                @foreach ($cluster as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="col">
                            <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                            <select class="form-select" name="no_rumah" id="no_rmh"></select>
                        </div>
    
                    </div>
            </div>
            <a href="/rumah-pengguna" class="btn btn-warning mt-4">kembali</a>
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

<script>
    $(document).ready(function() {
        $('#cluster').on('change', function() {
            var clusterID = $(this).val();
            if (clusterID) {
                $.ajax({
                    url: '/rumah-pengguna/cluster/'+clusterID,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "html",
                    success: function(data) {
                        $('#no_rmh').html(data);
                    }
                });
            } else {
                $('#no_rmh').empty();
            }
        });
    });


   
</script>

@endpush

@push('before-style')
<style>
    .form-label{
        font-weight: 500;
    }
</style>
@endpush
