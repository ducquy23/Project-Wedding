@extends('admin.layouts.master')
@section('content')
    <!-- Page Heading -->
    <h1 class="h1 mb-2 text-gray-800">Settings</h1>
    <form action="{{ route('admin.settingsPost',['id' => $config->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" id="image_preview"
                             src="{{ empty($config->logo) ? '/images/no-image.png' : \Storage::url($config->logo) }}"><span
                            class="font-weight-bold">{{ \Auth::user()->name }}</span><span
                            class="text-black-50">{{ $config->name }}</span><span> </span>
                        <input name="logo" type="file" id="image_url" style="display: none">
                    </div>
                </div>
                <div class="col-md-9 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label>
                                <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $config->name }}">
                            </div>
                            <div class="col-md-6"><label class="labels">Zalo</label>
                                <input type="text" name="zalo" class="form-control" value="{{ $config->zalo }}" placeholder="Enter zalo">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 m-2"><label class="labels">Google map</label>
                                <input type="text" name="google_map" class="form-control" placeholder="Enter google map" value="{{ $config->google_map }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Google analytic</label>
                                <input type="text" name="google_analytic" class="form-control" placeholder="Enter google analytic" value="{{ $config->google_analytic }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Facebook</label>
                                <input type="text" name="facebook_id" class="form-control" placeholder="Enter facebook" value="{{ $config->facebook_id }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Youtube</label>
                                <input type="text" name="youtube" class="form-control" placeholder="Enter youtube" value="{{ $config->youtube }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Tiktok</label>
                                <input type="text" name="tiktok" class="form-control" placeholder="Enter tiktok" value="{{ $config->tiktok }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Telegram</label>
                                <input type="text" name="telegram" class="form-control" placeholder="Enter telegram" value="{{ $config->telegram }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Whats app</label>
                                <input type="text" name="whats_app" class="form-control" placeholder="Enter whats app" value="{{ $config->whats_app }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Dribble</label>
                                <input type="text" name="dribble" class="form-control" placeholder="Enter dribble" value="{{ $config->dribble }}">
                            </div>
                            <div class="col-md-12 m-2"><label class="labels">Pinterest</label>
                                <input type="text" name="pinterest" class="form-control" placeholder="Enter pinterest" value="{{ $config->pinterest }}">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit">Save settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        const imagePreview = document.getElementById('image_preview');
        const imageUrlInput = document.getElementById('image_url');
        imagePreview.addEventListener('click', function () {
            imageUrlInput.click();
        });
        $(document).ready(function () {
            $('#image_url').change(function (event) {
                let x = URL.createObjectURL(event.target.files[0]);
                $('#image_preview').attr("src", x);
            });
        });
    </script>
@endsection
