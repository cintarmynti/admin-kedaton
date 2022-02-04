@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Splash Screen</h5>
            <p class="card-description">Splash Screen yang telah ditampilkan akan muncul di halaman Splash Screen</p>
            <form action="/splash-screen" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="">Judul</label>
                        <input type="text" required class="form-control" name="judul" aria-label="First name">
                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="form-label" for="">Foto</label>
                        <input type="file" class="form-control" id="filePhoto" name="gambar" aria-label="First name">
                        @error('gambar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <img id="output" class="mt-3" style="max-height: 200px; max-width: 300px">
                        
                    </div>

                </div>

                <div class="row mt-1">
                </div>
                <div class="row mt-1">
                    <div class="col">
                        <label class="form-label" for="">Deskripsi</label>
                        <textarea class="form-control" id="post" rows="12" name="desc"
                            aria-label="With textarea"></textarea>
                    </div>
                    @error('desc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <a href="/splash-screen" class="btn btn-warning mt-4">kembali</a>
                <button type="submit" class="btn btn-primary ml-4 mt-4">Simpan</a>
            </form>

        </div>
    </div>
@endsection


@push('after-script')

    <script>
        $(document).ready(function() {
            $('#post').summernote({
                placeholder: "Ketikan sesuatu disini . . .",
                height: '200'
            });
        });
    </script>

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

@endpush


@push('before-style')

    <style>
        .form-label {
            font-weight: 500;
        }

    </style>
@endpush


@push('after-script')
    <script>
        $(function() {
            $("#filePhoto").change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                $("#output").attr("src", x);
                console.log(event);
            });
        });
    </script>
@endpush
