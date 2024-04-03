<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            dd($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
