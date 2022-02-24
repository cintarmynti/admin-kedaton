@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="open-email-content">
                <div class="mail-header">
                    <div class="mail-title">
                        <h4>{{ $blog->judul }}</h4>
                    </div>
                    <div class="mail-actions">
                        <a href="{{route('blog.edit',$blog->id)}}" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="mail-info px-auto">
                        <img src="{{ asset('storage/' . $blog->gambar) }}" style="height: 300px; object-fit:cover">
                    </div>
                </div>
            </div>
            <div class="mail-text">
                {!! $blog->desc !!}
            </div>
            <div class="mail-attachment">
                <span class="attachment-info"><i class="fas fa-paperclip m-r-xxs"></i>{{ $image->count() }} Attachments</span>
                <div class="mail-attachment-files">
                    @foreach ($image as $item)
                        <div class="card">
                            <img onclick="image()" src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                style="height: 100px; width:200px; object-fit:cover">
                            <div class="card-body" style="padding-left: 28px">
                                <a href="{{ route('blogimg.delete', $item->id) }}" width="200px"
                                    class="btn btn-danger hapus mt-3 mx-auto">hapus gambar</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="ml-5 mb-5">
            <a href="{{ route('blog') }}" class="btn btn-primary mt-4">kembali</a>
        </div>
    </div>

@endsection

@push('after-script')
    <script>
        function image() {
            const viewer = new Viewer(document.getElementById('images'), {
                viewed() {
                    viewer.zoomTo(1);
                },
            });
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

        .panjang {
            width: 200px;
        }

    </style>
@endpush
