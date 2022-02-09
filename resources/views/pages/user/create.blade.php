@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Pengguna</h5>
        <p class="card-description">Pengguna yang telah ditambahkan akan muncul di halaman pengguna</p>
        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                <label for="formGroupExampleInput" class="form-label">Nama</label>
                <input value="{{ old('name') }}" type="text" required class="form-control" name="name"  aria-label="First name">
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label">NIK</label>
                <input value="{{ old('nik') }}" type="number" required class="form-control" name="nik"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                <label for="formGroupExampleInput" class="form-label">Alamat</label>
                <input value="{{ old('alamat') }}" type="text" required class="form-control" name="alamat"  aria-label="First name">
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label">No Telp</label>
                <input value="{{ old('phone') }}" type="text" required class="form-control" name="phone"  aria-label="Last name">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                <label for="formGroupExampleInput" class="form-label">Email</label>
                <input value="{{ old('email') }}" type="email" required class="form-control" name="email"  aria-label="First name">
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label">Password</label>
                <input value="{{ old('password') }}" type="password" required class="form-control" name="password"  aria-label="Last name">
                </div>
            </div>







            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="formGroupExampleInput" class="form-label ">Foto Pengguna</label>
                  <input value="{{ old('photo_identitas') }}" type="file" id="filePhoto" required class="form-control" name="photo_identitas"  aria-label="First name">
                  <img id="output" class="mb-3" style="max-height: 200px; max-width: 300px">
                </div>
                {{-- <img id="preview-image" src=""
                      alt="preview image" style="max-height: 250px;"> --}}
            </div>
                <a href="{{route('user')}}" class="btn btn-warning mt-4">kembali</a>
                <button type="submit"  class="btn btn-primary ml-4 mt-4">Simpan</a>
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
        $(document).ready(function() {
            $(".btn-success").click(function() {
                var lsthmtl = $(".clone").html();
                $(".increment").after(lsthmtl);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".realprocode").remove();
            });

            $('.select2').select2({
                // placeholder: 'Select Cluster',
                theme: 'bootstrap4',
                tags: true
            })
        });
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
