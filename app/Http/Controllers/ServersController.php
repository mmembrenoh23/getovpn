<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Exceptions\AdminException;
use Browser;


use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

use App\Model\Servers;
use App\Model\Server;


use App\Jobs\LogsApplication ;
use App\Jobs\LogsFileDownload;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Exception;

class ServersController extends Controller
{

    public function __construct(){
       $this->middleware('auth:admin');
    }

    //get all servers (folders)
    public function index(){
        try {
            $_directories=Servers::paginate(12);
            $request = request()->only('q');

            $message="Get all directories from database";

            if(isset($request['q'])){
                if(!Str::of($request['q'])->contains('reset')){
                    $_directories=Servers::where( 'server_name', 'like', '%' .$request['q']. '%')->paginate(12)->withPath(route('servers',['q'=>$request['q']]));
                    $message="Get all directories with a search term {$request['q']} ";
                }
            }

            LogsApplication::dispatch("ServersController","index-show",$message,Auth::guard('admin')->user()->id);
            ///  ->onQueue('processing');

            return view("admin.servers.servers",["dir"=> $_directories]);
        } catch (Exception $th) {

            $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);

            LogsApplication::dispatch("ServersController","index-show",$message,Auth::guard('admin')->user()->id);

            throw new AdminException($th->getMessage());
        }
    }


    public function getServerFiles($server_id){
        try {
            $server_id = base64_decode($server_id);
            $_files=$this->showDirFiles($server_id);
            $server_path=$_files['server_name'];

            $message ="get server files ({$_files['server_name']}). Total Files ".(count($_files));

            unset($_files['server_name']);

            LogsApplication::dispatch("ServersController","getServerFiles",$message,Auth::guard('admin')->user()->id);

            return view('admin.servers.server',['files'=>$_files,'server_name'=>$server_path]);
        }  catch (Exception $th) {

            $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);


            LogsApplication::dispatch("ServersController","getServerFiles",$message,Auth::guard('admin')->user()->id);

             throw new AdminException($th->getMessage());
        }

    }

    public function generetSecret($file_id){

        if(request()->ajax()){
            try {
                $file_id = base64_decode($file_id);

                $token= $this->getTokenSecret();

                $file = Server::find($file_id);

                $file->secret = $token;

                \Log::Info("token $token");
                \Log::Info("ID $file_id");

                if($file->save()){

                    LogsApplication::dispatch("ServersController","generetSecret","Secret $token saved at file: {$file->name} ",Auth::guard('admin')->user()->id);

                     $url=Str::of(route('voip-file-download',['secret'=>$token]))->replace('%24','$');

                     if(!empty($file->owner)){
                         Mail::to($file->owner)
                             ->send(new SendEmail(['url'=>$url,'secret'=>$token],"Secret key generated","emails.admin.email-secret"));
                     }
                     else{
                          LogsApplication::dispatch("ServersController","generetSecret","We cannot sent an email, the file doesn't have owner ",Auth::guard('admin')->user()->id);
                     }
                    return response()->json([
                        "error"=>0,
                        "message"=>"The secret was created",
                        "secret" => "$token"
                    ]);
                }

                LogsApplication::dispatch("ServersController","generetSecret","An error was occurred. Token: $token, file: {$file->name} ",Auth::guard('admin')->user()->id);

                return response()->json([
                        "error"=>1,
                        "message"=>"An error was occurred"]);

            } catch (\Throwable $th) {
                $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);


                LogsApplication::dispatch("ServersController","generetSecret",$message,Auth::guard('admin')->user()->id);

                throw new Exception($th->getMessage());
            }
        }
    }

    public function getDownloadFile($_file_id){

        try {
            $_file_id = base64_decode($_file_id);
            //$_ip,$_device,$_browser,$_OS
            $_info=$this->getBrowserInfo();
            LogsFileDownload::dispatch($_file_id,true, $this->getIp(),$_info['device'],$_info['browser'],$_info['OS'],Auth::guard('admin')->user()->id);

            return response()->download($this->copyFiletoDownload($_file_id));

        }  catch (Exception $th) {

            $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);

            LogsApplication::dispatch("ServersController","getDownloadFile",$message,Auth::guard('admin')->user()->id);

             throw new AdminException($th->getMessage());
        }

    }

    public function generateLink($file_id){
        if(request()->ajax()){
            try {
                $file_id = base64_decode($file_id);

                $file_server = Server::find($file_id);
                $file_path="";

                 \Log::Info("ID $file_id");

                if($file_server->secret != null){

                     \Log::Info("secret {$file_server->secret}");

                    $file_path=$file_server->url_download = Str::of(route('voip-file-download',['secret'=>$file_server->secret]))->replace('%24','$');

                    \Log::Info("file path {$file_path}");

                    $file_server->save();

                     LogsApplication::dispatch("ServersController","generateLink","Link to download file was generated. $file_path",Auth::guard('admin')->user()->id);

                    \Log::Info("file path {$file_path}");
                     return response()->json([
                        "error"=>0,
                        "message"=>'The link to download the file was generated',
                        "url_download"=>"{$file_path}"
                    ]);
                }

                LogsApplication::dispatch("ServersController","generateLink","Try to generate link to download file but the secret key doesn't exists",Auth::guard('admin')->user()->id);

                return  response()->json([
                        "error"=>1,
                        "message"=>"Please generate the secret key"
                    ]);


            } catch (Exception $e) {
                $message=serialize(["line"=>$e->getLine(),
                      "file"=>$e->getFile(),
                    "message"=>$e->getMessage()]);

                 LogsApplication::dispatch("ServersController","generateLink",$message,Auth::guard('admin')->user()->id);

                throw new Exception($e->getMessage(), 1);
            }
        }
        else{

        }
    }


    public function searchServer($query){
        if(request()->ajax()){
            try {

                \Log::info(Str::of($query)->contains('reset'));

                if(Str::of($query)->contains('reset')){
                    return view('admin.servers.search-server',['dir'=> Servers::paginate(12)->withPath(route('servers',['q'=>$query]))]);
                }
                else{
                    $server =Servers::where( 'server_name', 'like', '%' .$query. '%')->paginate(12)->withPath(route('servers',['q'=>$query]));
                    return view('admin.servers.search-server',['dir'=>  $server]);
                }


            } catch (\Throwable $th) {
                throw new Exception($th->getMessage());
            }
        }

    }

    private function copyFiletoDownload($_file_id){

        $file_server = Server::find($_file_id);

        $path=$file_server->path;

        \Log::info(public_path("files"));

        if(!File::isDirectory(public_path("files"))){
            File::makeDirectory(public_path("files"), 0777, true, true);
        }

        $path_ = pathinfo($path);

        $file = File::copy($path, public_path("files")."\\".$path_['basename']);

        $file =public_path("files\\{$path_['basename']}");

        LogsApplication::dispatch("ServersController","getDownloadFile -> copyFiletoDownload",
        "Download File: {$file_server->name} ",Auth::guard('admin')->user()->id);

        return $file;
    }

    private function getTokenSecret(){
        $string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$@$!%*?&#.-_";
        $string=str_shuffle($string);
        $result = '';

        \Log::info("Chart api key");
        for ($i = 10; $i > 0; --$i){
            \Log::info($string[rand(1,Str::length($string))]);
           $result .=  $string[rand(1,Str::length($string))];
        }

        return \Hash::make($result);
    }

     private function showDirFiles($_server_id){

        $server = Servers::find($_server_id);
        $_files=[];
        $_files['server_name']=$server->server_name;
        if($server){

            if($server->files()->exists()){

                foreach($server->files as $files){
                    $_files[]=[
                        'file_id'=>base64_encode($files->id),
                        'file_name'=>$files->name,
                        'file_size'=>$files->size,
                        'file_created'=>$files->created_file,
                        'file_owner'=>$files->owner
                    ];

                }
            }

        }

        return $_files;
    }

    private function getBrowserInfo(){

        $_info=[
            'OS'=>"",
            "device"=>"",
            "browser"=>""
        ];

        if(Browser::isDesktop()){
            $_info['device']= "Desktop";
        }
        else{
            $_info['device']= Browser::deviceFamily();
        }

        $_info['browser']= Browser::browserName();

        $_info['OS']= Browser::platformName();

        return $_info;

    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }


   /*  private function showDir(){

        $_directories =[];

        if(is_dir($this->server_main_path)){
            if ($dh = opendir($this->server_main_path)) {
                while (($file = readdir($dh)) !== false) {

                    if (is_dir($this->server_main_path .'\\'. $file) &&
                     !(Str::of($file)->contains('.')) && !(Str::of($file)->contains('..') )) {

                        $_directories[]=[
                            'dir_path'=>base64_encode($this->server_main_path.'\\'. $file),
                            'dir_name'=>$file
                        ];
                    }

                }
                closedir($dh);
             }
             else{
                 echo "no entra";
             }

        }
        else{
            echo "no entra";
        }

        return $_directories;
    } */

    /* private function showDirFiles($_dir){

        $files = [];
        if(is_dir($_dir)){
            if ($dh = opendir($_dir)) {
                while (($file = readdir($dh)) !== false) {
                    if(file_exists("$_dir\\$file")){
                        $fileinfo = pathinfo("$_dir\\$file");
                        if(isset($fileinfo['extension']) && !empty($fileinfo['extension'])){
                            $filesize = filesize("$_dir\\$file");

                            $date=\Carbon\Carbon::now();
                            $date->timestamp = filemtime("$_dir\\$file") ;
                            $files[]=[
                                'file_name'=>$fileinfo['filename'],
                                'file_extension'=>$fileinfo['extension'],
                                'file_size'=>$this->FileSizeConvert($filesize),
                                'file_created'=>$date->format('jS M, Y')
                            ];
                        }
                    }

                }
            }
        }

        return $files;
    }

    private function FileSizeConvert($bytes)
    {
        $bytes = intval($bytes);
            $arBytes = array(
                0 => array(
                    "UNIT" => "TB",
                    "VALUE" => pow(1024, 4)
                ),
                1 => array(
                    "UNIT" => "GB",
                    "VALUE" => pow(1024, 3)
                ),
                2 => array(
                    "UNIT" => "MB",
                    "VALUE" => pow(1024, 2)
                ),
                3 => array(
                    "UNIT" => "KB",
                    "VALUE" => 1024
                ),
                4 => array(
                    "UNIT" => "B",
                    "VALUE" => 1
                ),
            );

        $result=0;
        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    } */
}
