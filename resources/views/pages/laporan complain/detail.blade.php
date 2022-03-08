@extends('layouts.default')

@section('content')
<div class="card" id="images">
    <div class="card-body">
        <div class="open-email-content">
            <div class="mail-header">
                <div class="mail-title">
                    <h4>Catatan Complain</h4>
                </div>
            </div>
        </div>
        <div class="mail-text">
            {{$complain->catatan}}
            {{-- {!! $blog->desc !!} --}}
        </div>
        <div class="mail-attachment">
            <span class="attachment-info"><i class="fas fa-paperclip m-r-xxs"></i>{{ $image->count() }} Attachments</span>
            <div class="mail-attachment-files">
                @foreach ($image as $item)
                    <div class="card">
                        <img onclick="image()" src="{{ url('storage/' . $item->image) }}" class="card-img-top"
                            style="height: 100px; width:200px; object-fit:cover">
                        <div class="card-body" style="padding-left: 28px">
                            <a href="{{route('complainimg.delete', $item->id)}}" width="200px" class="btn btn-danger hapus mt-3">hapus gambar</a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="ml-5 mb-5">
        <a href="{{ route('complain') }}" class="btn btn-primary mt-4">kembali</a>
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

