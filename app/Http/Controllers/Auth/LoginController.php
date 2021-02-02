<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:admin')->except('logout');
        }

    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only(['username','password']);


        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['username' => $credentials['username'], 'password' =>  $credentials['password']])) {
            return  redirect()
            ->intended(route('servers'));
        }
        return back()->withInput()
        ->with([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('login')
            ->with('status','Admin has been logged out!');
    }


}

