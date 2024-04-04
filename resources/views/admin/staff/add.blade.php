@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm mới nhân viên</h1>
        <form action="{{ route('staff.addPost') }}" method="post" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên<span class="text-danger"> (*)</span></label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="text-danger"> (*)</span></label>
                        <input name="email" type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Ảnh</label> <br>
                        <input name="avatar" type="file" id="image_url" style="display: none">
                        <img src="/images/no-image.png" width="150" height="130" id="image_preview"
                             class="mt-1 img-fluid" alt="">
                        @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu<span class="text-danger"> (*)</span></label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Nhập lại mật khẩu<span class="text-danger"> (*)</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control"
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input name="phone" type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input name="address" type="text" id="address" class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address') }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select id="status" class="form-control custom-select @error('status') is-invalid @enderror" name="status">
                            <option selected="" disabled="">Chọn 1</option>
                            <option value="1" selected>Kích hoạt</option>
                            <option value="0">Không kích hoạt</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer ">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                    <a href="{{ route('staff.list') }}" class="btn btn-info">Danh sách</a>
                    <button class="btn btn-secondary" type="reset">Nhập lại</button>

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
