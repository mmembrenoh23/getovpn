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
            $users = User::all()->where("id","<>",Auth::guard('admin')->user()->id );
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

        $user = User::find($id);

        return view("admin.config.users.user-profile",['user'=>$user]);
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
        if(request()->ajax()){
            try {

                $user = User::find($id);

                $data = ["first_name"=>$request->get("txtFirstNameE"),
                    "last_name"=>$request->get("txtLastNameE"),
                    "email"=>$request->get("txtEmailE"),
                    "password"=>$request->get("txtPasswordE")];


                $flag=false;

                $exist_email = false;
                $email="";

                foreach ($data as $key =>$val) {

                    if (!empty($val) && $user->$key != $val) {

                        //check if the email exists
                        if ($key =='email') {
                            if (User::where('email', $val)->exists()) {
                                $exist_email = true;
                                 $email=$val;
                                continue;
                            }
                        }

                        if ($key =='password') {
                            $user->$key = Hash::make($val);
                        } else {
                            $user->$key = $val;
                        }

                        $flag = true;


                    }
                }

                if ($exist_email) {
                        LogsApplication::dispatch("UserController","update","There's another user with the same email $email",
                        Auth::guard('admin')->user()->id);

                        return response()->json(['message'=>"There's another user with the same email",'error'=>1]);
                }

                if ($flag) {
                    if ($user->save()) {
                        LogsApplication::dispatch("UserController","update","The user data was updated. user id = $id",
                        Auth::guard('admin')->user()->id);

                        return response()->json(['message'=>"The user data was updated",'error'=>0]);
                    } else {
                        $message ="An error was occurred when try to update the user data <br>".$request->get("txtFirstNameE")."<br>";
                        $message .=$request->get("txtLastNameE")."<br>";
                        $message .=$request->get("txtEmailE")."<br>";
                        LogsApplication::dispatch("UserController","update",$message, Auth::guard('admin')->user()->id);

                        return response()->json(['message'=>"An error was occurred when try to update the user data",'error'=>1]);
                    }
                } else {
                    $message ="There's no data to update";
                    LogsApplication::dispatch("UserController","update",$message,
                    Auth::guard('admin')->user()->id);

                    return response()->json(['message'=>"There's no data to update",'error'=>1]);

                }

            } catch (\Throwable $th) {
                $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);

                LogsApplication::dispatch("UserController","update",$message,Auth::guard('admin')->user()->id);

                return response()->json(['message'=>$th->getMessage(),'error'=>1]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {

                $exist = User::where('id',$id)->exists();

                if (!$exist) {
                    LogsApplication::dispatch("UserController","destroy","The user not exists $id",Auth::guard('admin')->user()->id);
                    return response()->json(['message'=>"The user not exists",'error'=>1]);
                }

                $user = User::find($id);

                if ($user->is_active) {
                    $user->is_active = 0;
                } else {
                    $user->is_active = 1;
                }

                if ($user->save()) {
                    LogsApplication::dispatch("UserController", "destroy", "The user $id was inactived", Auth::guard('admin')->user()->id);

                        return response()->json(['message'=>"The user was inactived",'error'=>0,'title'=> ($user->is_active == 1)?"Activated!":"Inactivated!"]);
                } else {
                    $message ="An error was occurred when try to update the user status $id";
                     LogsApplication::dispatch("UserController","destroy",$message, Auth::guard('admin')->user()->id);

                        return response()->json(['message'=>"An error was occurred when try to update the user status",
                        'error'=>1
                        ]);
                }


            } catch (\Throwable $th) {
                $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);

                LogsApplication::dispatch("UserController","destroy",$message,Auth::guard('admin')->user()->id);

                return response()->json(['message'=>$th->getMessage(),'error'=>1]);
            }
       }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function changePass($id, Request $request) {
        if (request()->ajax()) {
            $exist = User::where('id', $id)->exists();
            if (!$exist) {
                LogsApplication::dispatch("UserController", "changePass", "The user not exists $id", Auth::guard('admin')->user()->id);
                return response()->json(['message'=>"The user not exists",'error'=>1]);
            }

            $user =User::find($id);

            if (!\Str::of($user->password)->contains($request->get("txtPassword"))) {
                $user->password =Hash::make($request->get("txtPassword"));

                if ($user->save()) {
                    LogsApplication::dispatch("UserController", "changePass", "The user was changes his password", Auth::guard('admin')->user()->id);

                            return response()->json(['message'=>"Update was made it",'error'=>0,'title'=> ($user->is_active == 1)?"Activated!":"Inactivated!"]);
                } else {
                    $message ="An error was occurred when try to update the user status $id";
                    LogsApplication::dispatch("UserController","changePass",$message, Auth::guard('admin')->user()->id);

                    return response()->json(['message'=>"An error was occurred when try to update the user password",
                            'error'=>1
                            ]);
                }
            }

        }
    }
}
