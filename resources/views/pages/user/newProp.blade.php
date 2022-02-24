@extends('layouts.default')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{route('user.addNewProp')}}"  method="POST">
            @csrf
            <div class="col-md-12 mt-3 mb-2">
                {{-- <hr> --}}
                <h5>Tambahkan Properti</h5>
            </div>
            <div class="col-md-12">
                <input type="hidden" value="{{request()->id}}" name="user_id">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">Pilih Cluster</label>
                            <select class="form-select cluster" id="cluster_id">
                                <option value="">Pilih Cluster</option>
                                @foreach ($cluster as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="no_rmh" class="form-label">Pilih No Rumah</label>
                            <select class="form-select" name="properti_id" id="no_rmh">
                                <option value="" selected disabled>Pilih No Rumah</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="formGroupExampleInput" class="form-label">RT</label>
                        <input value="{{ old('RT') }}" type="number" required class="form-control" id="RT"
                            readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="formGroupExampleInput" class="form-label">RW</label>
                        <input value="{{ old('RW') }}" type="number" required class="form-control" id="RW"
                            readonly>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="form-label">Alamat</label>
                            <input rows="5" type="text" required class="form-control" id="alamat" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <br>
                            <button onclick="tambahRumah()" class="btn btn-success mt-2" type="button"><i
                                    class="glyphicon glyphicon-remove"></i>
                                Tambah</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-stripped">
                            <thead>
                                <th>Cluster</th>
                                <th>No. Rumah</th>
                                <th>RT</th>
                                <th>RW</th>
                                <th>Alamat</th>
                                <th></th>
                            </thead>
                            <tbody id="data-detail">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('properti') }}" class="btn btn-warning mt-4">kembali</a>
                        <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>


@endsection

@push('after-script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#filePhoto").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output").attr("src", x);
                console.log(event);
            });

        });

        var inc = 0;

        function tambahRumah() {
            var id = $("#no_rmh").val();
            var nomer = $("#no_rmh option:selected").text();
            var cluster = $("#cluster_id option:selected").text();
            var rt = $('#RT').val();
            var rw = $('#RW').val();
            var alamat = $('#alamat').val();

            var html =
                `<tr id="row${inc}">
                    <input type="hidden" name="properti_id[]" value="${id}">
                    <td>${cluster}</td>
                    <td>${nomer}</td>
                    <td>${rt}</td>
                    <td>${rw}</td>
                    <td>${alamat}</td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteRumah(${inc})">Hapus</button>
                    </td>
                </tr>
                `;

            $('#data-detail').append(html);

            $('#RT').val('');
            $('#RW').val('');
            $('#alamat').val('');

        }

        function deleteRumah(id) {
            $("#row" + id).remove()
        }

        $(document).ready(function() {
            $(".btn-success").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });
        });

        function onchange_comma(id, value) {
            var x = numeral($("#" + id).val()).format('0,0');
            $("#" + id).val(x);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.cluster').on('change', function() {
                var clusterID = $(this).val();
                if (clusterID) {
                    $.ajax({
                        url: '/user/nomer/' + clusterID,
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
                var no_rmh = $(this).val();
                if (no_rmh) {
                    $.ajax({
                        url: '/properti-detail-json/' + no_rmh,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#RT').val(data.properti.RT);
                            $('#RW').val(data.properti.RW);
                            $('#alamat').val(data.properti.alamat);
                        }
                    });
                } else {
                    $('#no_rmh').empty();
                }
            });
        });
    </script>
@endpush
