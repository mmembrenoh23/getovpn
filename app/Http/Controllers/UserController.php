<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

use App\Jobs\LogsApplication ;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all();
        LogsApplication::dispatch("UserController","index-show"," View all users",Auth::guard('admin')->user()->id);

         return view("admin.config.users.users",['users'=>$users]);
        } catch (\Throwable $th) {
           $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);

            LogsApplication::dispatch("UserController","index-show",$message,Auth::guard('admin')->user()->id);

            throw new \App\Exceptions\AdminException($th->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request()->ajax()){
            try {

                $is_user_exist=User::where('username',$request->get('txtUsername'))->exists();

                if($is_user_exist){
                    LogsApplication::dispatch("UserController",
                        "store","The username {$request->get('txtUsername')} already exists ",Auth::guard('admin')->user()->id);

                 return response()->json(['message'=>"The username {$request->get('txtUsername')} already exists ",'error'=>1]);
                }

                $is_email_exist=User::where('email',$request->get('txtEmail'))->exists();

                if($is_email_exist){
                    LogsApplication::dispatch("UserController",
                        "store","The email {$request->get('txtEmail')} already exists ",Auth::guard('admin')->user()->id);

                 return response()->json(['message'=>"The email {$request->get('txtEmail')} already exists ",'error'=>1]);
                }

                $_is_created= User::Create([
                    "first_name"=>$request->get('txtFirstName'),
                    "last_name"=>$request->get('txtLastName'),
                    "username"=>$request->get('txtUsername'),
                    "email"=>$request->get('txtEmail'),
                    "password"=>Hash::make($request->get('txtPassword'))
                ]);

                if($_is_created){
                        LogsApplication::dispatch("UserController",
                        "store","The user was created ".$request->get('txtFirstName')
                        ." ".$request->get('txtLastName')
                        ." ".$request->get('txtUsername'),Auth::guard('admin')->user()->id);

                        return response()->json(['message'=>"The user was created",'error'=>0]);

                }

                LogsApplication::dispatch("UserController",
                        "store","An error was occurred ".$request->get('txtFirstName')
                        ." ".$request->get('txtLastName')
                        ." ".$request->get('txtUsername'),Auth::guard('admin')->user()->id);

                 return response()->json(['message'=>"An error was occurred",'error'=>1]);

            } catch (\Throwable $th) {
                LogsApplication::dispatch("UserController",
                        "store",$th->getMessage(),Auth::guard('admin')->user()->id);
                throw new \Exception($th->getMessage());
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()){
            try {

                 $user =User::find($id);

                 $message =$user->username." <br> ".$user->first_name."<br>".$user->last_name;

                 LogsApplication::dispatch("UserController","show","Search user id $id <br> $message",Auth::guard('admin')->user()->id);

                 return response()->json([
                     "user_id"=>$id,
                     "first_name"=>$user->first_name,
                     "last_name"=>$user->last_name,
                     "email"=>$user->email
                 ]);


            } catch (\Throwable $th) {
                 $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);

                LogsApplication::dispatch("UserController","show",$message,Auth::guard('admin')->user()->id);

                throw new \App\Exceptions\AdminException($th->getMessage());
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
