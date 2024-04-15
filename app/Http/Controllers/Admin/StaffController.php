<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Admin::query();
        if (!$user->hasRole('Admin')) {
            // Lấy danh sách các vai trò của người dùng
            $userRoles = $user->roles()->pluck('name')->toArray();
            // Lọc nhân viên có vai trò tương tự với vai trò của người dùng
            $query->whereHas('roles', function ($q) use ($userRoles) {
                $q->whereIn('name', $userRoles);
            });
        }
        // tìm kiếm
        if ($request->has('search')) {
            $search = $request->input('search') ?? '';
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        // lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status') ?? 1;
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        $query->with('roles');
        if ($request->has('show_entries')) {
            $showEntries = $request->input('show_entries') ?? 10;
            $listStaff = $query->orderBy('id', 'DESC')->paginate($showEntries);
        } else {
            $listStaff = $query->orderBy('id', 'DESC')->paginate(PaginationEnum::PER_PAGE);
        }
        return view('admin.staff.list', compact('listStaff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            // Nếu là 'Admin', lấy tất cả các vai trò
            $roles = Role::all();
        } else {
            // Nếu không phải 'Admin', lấy các vai trò của người dùng
            $roles = $user->roles;
        }
        return view('admin.staff.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        try {
            $admin = new Admin();
            $admin->password = Hash::make($request->password);
            $admin->name = $request->input('name') ?? '';
            $admin->email = $request->input('email') ?? '';
            $admin->phone = $request->input('phone') ?? '';
            $admin->status = $request->input('status') ?? 1;
            $admin->address = $request->input('address') ?? '';
            $admin->avatar = $request->file('avatar') ?? null;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $admin->avatar = uploadFile('admin', $request->file('avatar'));
            }
            $admin->save();
            if ($request->has('role')) {
                $admin->assignRole($request->input('role'));
            }
            toastr()->success('Add user successfully !');
            return redirect()->route('staff.add');
        } catch (Exception $exception) {
            toastr()->error('You have an ' . $exception . ' error when add new !');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();

        // Lấy vai trò hiện tại của người dùng
        $userRoles = $user->roles()->pluck('name')->toArray();

        // Kiểm tra quyền hạn của người dùng
        if (!$user->hasRole('Admin')) {
            toastr()->error('Access denied', 'Unauthorized');
            return redirect()->route('staff.list');
        }

        try {
            // Lấy thông tin admin và các vai trò của admin
            $admin = Admin::with('roles')->findOrFail($id);
            $adminRoles = $admin->roles()->pluck('name')->toArray();

            // Lấy tất cả các vai trò (nếu là 'Admin'), hoặc lấy các vai trò của người dùng (nếu không phải 'Admin')
            $roles = $user->hasRole('Admin') ? Role::all() : $user->roles;
            return view('admin.staff.edit', compact('roles', 'adminRoles', 'admin'));

        } catch (\Exception $e) {
            toastr()->error('Admin not found', 'Failed');
            return redirect()->route('staff.list');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffRequest $request, string $id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                toastr()->error('Admin not found', 'Failed');
                return redirect()->back();
            }
            if ($request->has('role')) {
                $roles = $request->input('role');
                $admin->syncRoles($roles);
            }
            $params = $request->except('_token', 'password_confirmation', 'role');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deletedAvatar = Storage::delete('/public/' . $admin->avatar);
                if ($deletedAvatar) {
                    $params['avatar'] = uploadFile('image', $request->file('avatar'));

                } else {
                    toastr()->error('Delete avatar not successfully', 'Failed');
                    return redirect()->back();
                }
            }

            $resultUpdate = Admin::where('id', $id)->update($params);
            if ($resultUpdate) {
                toastr()->success('Update staff successfully !', 'Sucesss');
                return redirect()->route('staff.list');
            } else {
                toastr()->error('You have an error when update staff !', 'Failed');
                return redirect()->route('staff.edit', ['id' => $id]);
            }
        } catch (Exception $exception) {
            toastr('Have an error :' . $exception);
            return redirect()->route('staff.list');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (!empty($id)) {
                $admin = Admin::findOrFail($id);
                // check có phải đang định xóa nhân viên đang đăng nhập không
                if (Auth::guard('admin')->check() && Auth::guard('admin')->id() === $admin->id) {
                    toastr()->error('Bạn không thể xóa nhân viên đang đăng nhập vào hệ thống!', 'Failed');
                    return redirect()->route('staff.list');
                }
                // Nếu không phải thì cho xóa
                $admin->delete();
                toastr()->success('Delete staff successfully !', 'Successfully');
                return redirect()->route('staff.list');
            }
            toastr()->error('You have an error when delete staff !', 'Failed');
            return redirect()->route('staff.list');

        } catch (Exception $e) {
            toastr('Have an error :' . $e);
            return redirect()->route('staff.list');
        }
    }

    public function updateStatus($id, StaffRequest $request)
    {
        try {
            $item = Admin::find($id);
            if (!$item) {
                return response()->json(['message' => 'Không tìm thấy mục'], 404);
            }
            $newStatus = $request->input('status');
            $item->status = $newStatus;
            $item->save();
            return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
        } catch (Exception $e) {
            return response()->json('You have an error :' . $e);
        }

    }
    public function trash(Request $request) {
        $user = Auth::user();
        $query = Admin::onlyTrashed();
        if (!$user->hasRole('Admin')) {
            // Lấy danh sách các vai trò của người dùng
            $userRoles = $user->roles()->pluck('name')->toArray();
            // Lọc nhân viên có vai trò tương tự với vai trò của người dùng
            $query->whereHas('roles', function ($q) use ($userRoles) {
                $q->whereIn('name', $userRoles);
            });
        }
        // tìm kiếm
        if ($request->has('search')) {
            $search = $request->input('search') ?? '';
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        // lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status') ?? 1;
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        $query->with('roles');
        if ($request->has('show_entries')) {
            $showEntries = $request->input('show_entries') ?? 10;
            $listStaff = $query->orderBy('id', 'DESC')->paginate($showEntries);
        } else {
            $listStaff = $query->orderBy('id', 'DESC')->paginate(PaginationEnum::PER_PAGE);
        }

        return view('admin.staff.trash',compact('listStaff'));
    }
    public function restore($id) {
        try {
            if ($id) {
                $restore = Admin::withTrashed()->find($id);
                $restore->restore();
                toastr()->success('Khôi phục nhân viên thành công', 'success');
                return redirect()->route('staff.trash');
            }
            toastr()->success('Có lỗi xảy ra', 'danger');
            return  redirect()->route('staff.trash');

        } catch (Exception $e) {
            return response()->json('You have an error :' . $e);
        }
    }
    public function permanentlyDeleted($id) {
        try {
            if ($id) {
                $deleted = Admin::onlyTrashed()->find($id);
                $deleted->forceDelete();
                toastr()->success('Xóa vĩnh viễn nhân viên thành công', 'success');
                return redirect()->route('staff.trash');
            }
            toastr()->success('Có lỗi xảy ra', 'danger');
            return  redirect()->route('staff.trash');
        } catch (Exception $e) {
            return response()->json('You have an error :' . $e);
        }

    }
}
