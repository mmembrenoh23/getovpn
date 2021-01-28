<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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


    public function getServerFiles($server_path){

        /*$this->validate(request(), [
            'server_path' => 'required'
        ]);
        */
        $server_path=base64_decode($server_path);

        $_files=$this->showDirFiles($server_path);
        //ProcessVPNFiles::dispatch($server_path);
        
        foreach($_files as $key => $file){

            $server = Server::where('name',$file['file_name'])
                                ->where('path',$server_path.'\\'.$file['file_name'].'.'.$file['file_extension']);   

            \Log::info($server_path.'\\'.$file['file_name']);

            if($server->exists()){

                $server = $server->first();
                $_files[$key]['id']=\Hash::make($server->id);
                $_files[$key]['owner']=$server->owner;

            }else{
                unset($_files[$key]);
            }

        }

        $server_path=basename($server_path);


        return view('admin.servers.server',['files'=>$_files,'server_name'=>$server_path]);

    }

    public function showAttribute($fid){
        if(request()->ajax()){
  
            $file = Server::where(\DB::raw('md5(id)'),$id)->first();
            
        }
    }

    public function editAttribute(Request $request){

        if($request->ajax()){

            try 
            {
                $input = $request->only(['fid','title','owner']);
            } catch (\Throwable $th) {
                //throw $th;
            }

        }
    }

    private function showDir(){

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
    }

    private function showDirFiles($_dir){

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
    }
}
