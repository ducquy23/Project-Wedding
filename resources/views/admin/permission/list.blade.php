@extends('admin.layouts.master')
@push('styles')
    <link href="/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quản lý quyền</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách quyền</h6>
            <div>
                <a href="{{ route('permission.add') }}" class="btn btn-success mr-2">Thêm mới</a>
                <a href="" class="mr-3 pl-2 pr-2 btn btn-danger" title="Thùng rác">
                    <i class="fa-regular fa-trash-can m-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <form action="" method="get" id="filterForm">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="dataTable_length">
                                    <label>Show
                                        <select name="show_entries" aria-controls="dataTable"
                                                class="custom-select custom-select-sm form-control form-control-sm"
                                                id="entriesPerPage" onchange="submitForm()">
                                            <option value="10" @if(request('show_entries') == 10) selected @endif>10
                                            </option>
                                            <option value="25" @if(request('show_entries') == 25) selected @endif>25
                                            </option>
                                            <option value="50" @if(request('show_entries') == 50) selected @endif>50
                                            </option>
                                            <option value="100" @if(request('show_entries') == 100) selected @endif>
                                                100
                                            </option>
                                        </select> entries
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <form action="" method="get">
                                    <div id="dataTable_filter" class="dataTables_filter">
                                        <label>
                                            Search (name):<input type="search" name="search"
                                                                 value="{{ request('search') }}"
                                                                 class="form-control form-control-sm"
                                                                 placeholder=""
                                                                 aria-controls="dataTable">
                                            <button type="submit" class="btn btn-outline-success">Tìm kiếm</button>
                                        </label>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                                   role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                <tr role="row">
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending" style="width: 30.2px;">
                                        STT
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Position: activate to sort column ascending"
                                        style="width: 146.2px;">Name
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 133.2px;">Guard Name
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Salary: activate to sort column ascending" style="width: 120.2px;">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($permissions))
                                    @foreach($permissions as $key => $value)
                                        <tr class="{{ ($key % 2 == 0) ? 'odd' : 'even' }}">
                                            <td class="sorting_1">{{ $key + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->guard_name }}</td>
                                            <td>
                                                <div class="dropdown text-center">
                                                    <!-- Icon here (e.g., three dots icon) -->
                                                    <i class="fas fa-ellipsis-v p-2" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false"></i>
                                                    <div class="dropdown-menu"
                                                         aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                           href="">Chi tiết</a>
                                                        <a class="dropdown-item"
                                                           href="">Sửa</a>
                                                        <a class="dropdown-item show_confirm"
                                                           data-name="{{ $value->name }}"
                                                           href="">Xóa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                Showing {{ $permissions->firstItem() }} to {{ $permissions->lastItem() }}
                                of {{ $permissions->total() }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    {{ $permissions->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            document.getElementById("filterForm").submit();
        }

        function alertConfirmation() {
            $('.show_confirm').click(function (event) {
                var href = $(this).attr("href"); // Lấy URL từ thuộc tính href của thẻ <a>
                var name = $(this).data("name");
                event.preventDefault();

                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc chắn muốn xóa nhân viên "' + name + '" này không ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // Người dùng đã xác nhận xóa
                            // Chuyển hướng đến URL xóa
                            window.location.href = href;
                        } else {
                            // Người dùng đã bấm nút "Hủy"
                            // Không làm gì cả hoặc có thể xử lý khác nếu cần
                        }
                    });
            });
        }

        alertConfirmation();

    </script>

@endsection

