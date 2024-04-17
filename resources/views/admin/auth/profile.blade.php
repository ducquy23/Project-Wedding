@extends('admin.layouts.master')
@section('content')
    <!-- Page Heading -->
    <h1 class="h1 mb-2 text-gray-800">Profile Settings</h1>
    <div class="container rounded bg-white mt-5 mb-5" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);">
        <form action="{{ route('admin.profilePost',['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" id="image_preview"
                            src="{{ empty($user->avatar) ? '/images/no-image-user.png' : \Storage::url($user->avatar) }}"><span
                            class="font-weight-bold">{{ $user->name }}</span><span
                            class="text-black-50">{{ $user->email }}</span><span> </span>
                        <input name="avatar" type="file" id="image_url" style="display: none">
                    </div>
                </div>
                <div class="col-md-9 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12"><label class="labels">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter full name" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Mobile Number</label>
                                <input type="number" name="phone" class="form-control" placeholder="Enter phone number" value="{{ $user->phone }}">
                            </div>
                            <div class="col-md-12 mt-2"><label class="labels">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter address" value="{{ $user->address }}">
                            </div>
                            <div class="col-md-12 mt-2"><label class="labels">Gender</label>
                                <select id="gender" class="form-control custom-select"
                                        name="gender">
                                    <option value="0" @if($user->gender == 0) selected @endif>Nam</option>
                                    <option value="1" @if($user->gender == 1) selected @endif>Nữ</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2"><label class="labels">Status</label>
                                <select id="status" class="form-control custom-select"
                                        name="status">
                                    <option value="1" @if($user->status == 1) selected @endif>Active</option>
                                    <option value="2" @if($user->status == 2) selected @endif>Not Active</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control" placeholder="Enter email" name="email"
                                       value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
