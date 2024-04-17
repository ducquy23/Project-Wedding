<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Models\WebConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('admin.auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function loginPost(LoginRequest $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (!empty($credentials)) {
                if (Auth::guard('admin')->attempt($credentials)) {
                    $request->session()->regenerate();
                    toastr()->success('Login successfully !', 'success');
                    return redirect()->route('admin.dashboard');
                }
            }

            toastr()->error('Login failed !', 'error');
            return back()->withErrors('email', 'Email và password không chính xác')->onlyInput('email');
        } catch (Exception $e) {
            toastr()->error('You have an error !', 'error');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Display the specified resource.
     */
    public function profile(string $id)
    {
        try {
            if (!$id) {
                toastr()->error('Don\"t exist account !','error');
                return redirect()->route('admin.login');
            }
            $user = Admin::find($id);
            return view('admin.auth.profile',compact('user'));
        } catch (Exception $e) {
            toastr()->error('You have an error !', 'error');
            return back();
        }


        return view('admin.auth.profile');
    }

    public function profilePost (string $id,Request $request) {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                toastr()->error('Admin not found', 'Failed');
                return redirect()->back();
            }
            $params = $request->except('_token');
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:admins,email,' . $id,
            ], [
                'email.unique' => 'The email has already been taken by another admin.'
            ]);
            // Kiểm tra validator
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
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
                return redirect()->route('admin.profile',['id' => $id]);
            } else {
                toastr()->error('You have an error when update staff !', 'Failed');
                return redirect()->route('staff.edit', ['id' => $id]);
            }
        } catch (Exception $exception) {
            toastr('Have an error :' . $exception);
            return redirect()->route('admin.profile',['id' => $id]);
        }
    }
    public function settings() {
        $config = WebConfig::find(1);

        return view('admin.auth.settings',compact('config'));
    }
    public function settingsPost(string $id,Request $request) {
        try {
            $config = WebConfig::find($id);
            if (!$config) {
                toastr()->error('Config not found', 'Failed');
                return redirect()->back();
            }
            $params = $request->except('_token');
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $deletedAvatar = Storage::delete('/public/' . $config->logo);
                if ($deletedAvatar) {
                    $params['logo'] = uploadFile('image', $request->file('logo'));

                } else {
                    toastr()->error('Delete logo not successfully', 'Failed');
                    return redirect()->back();
                }
            }
            $resultUpdate = WebConfig::where('id', $id)->update($params);
            if ($resultUpdate) {
                toastr()->success('Update config successfully !', 'Sucesss');
                return redirect()->route('admin.settings',['id' => $id]);
            } else {
                toastr()->error('You have an error when update config !', 'Failed');
                return redirect()->route('admin.settings', ['id' => $id]);
            }
        } catch (Exception $exception) {
            toastr('Have an error :' . $exception);
            return redirect()->route('admin.settings',['id' => $id]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
