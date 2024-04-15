<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        $roles = Role::all();
        $userId = $this->route('staff.editPost');
        switch ($this->method()) {
            case 'POST':
                switch ($currentAction) {
                    case 'update' :
                        $admin = Admin::find($this->route('id')); // lấy id của người dùng đang update hiện tại
                        $rules = [
                            'name' => 'required|string|max:255',
                            'email' => [
                                'required',
                                'email',
                                Rule::unique('admins', 'email')->ignore($admin->id), // bỏ qua email của user đang update hiện tại
                                'max:255',
                            ],
                            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra định dạng và kích thước tệp tin ảnh
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'phone' => 'nullable|string|max:15',
                            'address' => 'nullable|string|max:255',
                            'status' => 'required|in:0,1',
                            'role' => 'required',
                        ];
                        break;
                    case 'store' :
                        $rules = [
                            'name' => 'required|string|max:255',
                            'email' => 'required|email|unique:admins,email|max:255',
                            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra định dạng và kích thước tệp tin ảnh
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'phone' => 'nullable|string|max:15',
                            'address' => 'nullable|string|max:255',
                            'status' => 'required|in:0,1',
                            'role' => 'required',
                        ];
                        break;
                }
                break;
            default:
                break;
        }
        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email phải là định dạng hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password_confirmation.required' => 'Nhập lại mật khẩu là trường bắt buộc.',
            'status.required' => 'Trạng thái là trường bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'avatar.image' => 'Ảnh đại diện phải là một tệp tin ảnh (jpeg, png, jpg, gif).',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Kích thước ảnh đại diện tối đa là 2MB.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'role.required' => 'Vai trò là trường bắt buộc.',
        ];
    }
}
