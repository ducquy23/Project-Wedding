<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        switch ($this->method()) {
            case 'POST':
                switch ($currentAction) {
                    case 'update' :
                    case 'store' :
                        $rules = [
                            'name' => 'required|string|max:255',
                            'email' => 'required|email|unique:users,email|max:255',
                            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra định dạng và kích thước tệp tin ảnh
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'phone' => 'nullable|string|max:15',
                            'address' => 'nullable|string|max:255',
                            'status' => 'required|in:0,1',
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
            'status.required' => 'Trạng thái là trường bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'avatar.image' => 'Ảnh đại diện phải là một tệp tin ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Kích thước ảnh đại diện tối đa là 2MB.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ];
    }
}
