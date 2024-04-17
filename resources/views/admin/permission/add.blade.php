@extends('admin.layouts.master')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Thêm mới Quyền </h1>
    <form action="" method="post" enctype="multipart/form-data">
        @method('POST')
        @csrf
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên<span class="text-danger"> (*)</span></label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email<span class="text-danger"> (*)</span></label>
                    <input name="email" type="text" id="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}">
                    @error('email')
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
@endsection
