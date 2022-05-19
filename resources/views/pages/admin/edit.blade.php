@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Admin</h5>
            <form action="/admin/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="">Nama</label>
                        <input type="text" value="{{old('name', $user->name)}}" required class="form-control" name="name" >
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="form-label" for="">Email</label>
                        <input type="email" value="{{old('email', $user->email)}}" class="form-control" id="filePhoto" name="email" >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="">password</label>
                        <input type="password" class="form-control" id="filePhoto" name="password" >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="hidden" name="id" value="{{$user->id}}">
                </div>


                <a href="/admin" class="btn btn-warning mt-4">kembali</a>
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
