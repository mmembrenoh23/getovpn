<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Model\Servers;
use App\Model\Server;


//use App\Jobs\ProcessServers ;
use App\Jobs\ProcessVPNFiles ;

class ServersController extends Controller
{
    private $server_main_path = "C:\\Server";

    public function __construct(){
       $this->middleware('auth:admin');
      // ProcessServers::dispatch($this->server_main_path);
    }

    //get all servers (folders)
    public function index(){

        $_directories=$this->showDir();

        return view("admin.servers.servers",["dir"=> $_directories]);
    }


    public function getServerFiles($server_id){

        /*$this->validate(request(), [
            'server_path' => 'required'
        ]);
        */
        $server_id = base64_decode($server_id);
        $_files=$this->showDirFiles($server_id);
        $server_path=$_files['server_name'];

        unset($_files['server_name']);

        return view('admin.servers.server',['files'=>$_files,'server_name'=>$server_path]);

    }

    public function generetSecret($file_id){

        if(request()->ajax()){
            $file_id = base64_decode($file_id);

            $token= $this->getTokenSecret();

            $file = Server::find($file_id);

            $file->secret = $token;

            \Log::Info("token $token");
            \Log::Info("ID $file_id");

            if($file->save()){
                return response()->json([
                    "error"=>0,
                    "message"=>"The secret was created",
                    "secret" => "$token"
                ]);
            }

            return response()->json([
                    "error"=>1,
                    "message"=>"An error was occurred"]);

        }
        else{
          \Log::warning($e->getMessage());
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function getDownloadFile($_file_id){

        try {
            $_file_id = base64_decode($_file_id);

            return response()->download($this->copyFiletoDownload($_file_id));

        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            throw new Exception($e->getMessage(), 1);
        }

    }

    public function generateLink($file_id){
        if(request()->ajax()){
            try {
                $file_id = base64_decode($file_id);

                $file_server = Server::find($file_id);
                $file_path="";

                 \Log::Info("ID $file_id");

                 \Log::Info("secret {$file_server->secret}");

                if($file_server->secret != null){
                    $path=$file_server->path;
                    $path_ = pathinfo($path);
                    $file_path=$file_server->url_download = route('voip-file-download',['secret'=>$file_server->secret]);
                    $file_server->save();

                    return response()->json([
                        "error"=>0,
                        "message"=>'The link to download the file was generated',
                        "url_download"=>$file_path
                    ]);
                }

                return  response()->json([
                        "error"=>1,
                        "message"=>"Please generate the secret key"
                    ]);


            } catch (Exception $e) {
                \Log::warning($e->getMessage());
                throw new Exception($e->getMessage(), 1);
            }
        }
        else{

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

    private function showDir(){
        $servers =[];

        foreach(Servers::all() as $server){
            $servers[]= [
                    'id'=>base64_encode($server->id),
                    'dir_name'=>$server->server_name,
                    'dir_path'=>$server->path
            ];
        }

        return $servers;
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
