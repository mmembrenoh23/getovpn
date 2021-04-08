<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Jobs\LogsApplication ;
use App\Model\UserAttempt;

class LoginController extends Controller
{
    public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:admin')->except('logout');
        }

    public function showLoginForm()
    {
        \Log::info(\Hash::make('Test2021*'));
        return view('authentication.login');
    }

    public function adminLogin(Request $request)
    {
        try {
           $credentials = $request->only(['username','password']);


            $this->validate($request, [
                'username'   => 'required',
                'password' => 'required|min:6'
            ]);

            if (Auth::attempt(['username' => $credentials['username'], 'password' =>  $credentials['password'], 'is_active'=> 1])) {
                return  redirect()
                ->intended(route('servers'));
            }

            UserAttempt::create([
                'username' =>  $credentials['username'],
                'message' => 'The provided credentials do not match our records.',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]);

            return back()->withInput()
            ->with([
                'error' => 'The provided credentials do not match our records.',
            ]);
        } catch (\Throwable $th) {

            $message ="An error was occurred when the user ".$request->get("username")." try to login";
            LogsApplication::dispatch("LoginController","adminLogin",$message);

            \Log::warning($th->getMessage());
            throw new \App\Exceptions\CustomException($th->getMessage());

        }



    }

    public function logout()
    {
        Auth::logout();
        return redirect()
            ->route('login')
            ->with('status','Admin has been logged out!');
    }


}

