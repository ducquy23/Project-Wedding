@extends('admin.layouts.master')
@push('styles')
    <link href="/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Nhân viên</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách nhân viên</h6>
            <div>
                <a href="{{ route('staff.add') }}" class="btn btn-success mr-2">Thêm mới nhân viên</a>
                <a href="" class="mr-3 p-1" title="Thùng rác">
                    <i class="fa-regular fa-trash-can"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="dataTable_length"><label>Show <select
                                        name="dataTable_length" aria-controls="dataTable"
                                        class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries</label></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <label>
                                    Search:<input type="search" class="form-control form-control-sm" placeholder=""
                                                  aria-controls="dataTable">
                                </label>
                            </div>
                        </div>
                    </div>
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
                                        aria-label="Office: activate to sort column ascending" style="width: 141.2px;">
                                        Email
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Age: activate to sort column ascending" style="width: 66.2px;">
                                        Avatar
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Age: activate to sort column ascending" style="width: 66.2px;">
                                        Role
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Start date: activate to sort column ascending"
                                        style="width: 133.2px;">Status
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-label="Salary: activate to sort column ascending" style="width: 120.2px;">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">STT</th>
                                    <th rowspan="1" colspan="1">Name</th>
                                    <th rowspan="1" colspan="1">Email</th>
                                    <th rowspan="1" colspan="1">avatar</th>
                                    <th rowspan="1" colspan="1">Role</th>
                                    <th rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1">Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @if(!empty($listStaff))
                                    @foreach($listStaff as $key => $value)
                                        <tr class="{{ ($key % 2 == 0) ? 'odd' : 'even' }}">
                                            <td class="sorting_1">{{ $key + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td class="text-center">
                                                {!! app('Helper')->showUserAvatar($value,'','','width="80"') !!}
                                            </td>
                                            <td>
                                                @foreach($value->roles as $role)
                                                    {{ $role->name }}
                                                @endforeach
                                            </td>

                                            <td class="text-center">
                                                {{--                                                @if($value->status == 0)--}}
                                                {{--                                                    Not Active--}}
                                                {{--                                                @endif--}}
                                                {{--                                                @if($value->status == 1)--}}
                                                {{--                                                    Active--}}
                                                {{--                                                @endif--}}
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="dropdown text-center">
                                                    <!-- Icon here (e.g., three dots icon) -->
                                                    <i class="fas fa-ellipsis-v p-2" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false"></i>
                                                    <div class="dropdown-menu"
                                                         aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                           href="">Sửa</a>
                                                        <a class="dropdown-item show_confirm"
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
                                Showing {{ $listStaff->firstItem() }} to {{ $listStaff->lastItem() }}
                                of {{ $listStaff->total() }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    {{ $listStaff->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

