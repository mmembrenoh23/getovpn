<?php

namespace App\Http\Controllers;

use App\Jobs\LogsFileDownload;
use App\Jobs\LogsApplication;
use Illuminate\Http\Request;
use App\Model\Server;

use Browser;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DownloadController extends Controller
{
    private $getClientId;
    public function downloadFile($secret){
        try {

            $this->getClientId=$this->getIp();


            return response()->download($this->copyFiletoDownload($secret));

        } catch (\Throwable $th) {

             $message=serialize(["line"=>$th->getLine(),
                      "file"=>$th->getFile(),
                    "message"=>$th->getMessage()]);
             \Log::warning( $message);
            throw new \App\Exceptions\CustomException($th->getMessage());
        }

    }

    private function copyFiletoDownload($_secret){

        try {
            $file_server = Server::where('secret',$_secret)->firstOrFail();

            $path=$file_server->path;

            \Log::info(public_path("files"));

            if(!File::isDirectory(public_path("files"))){
                File::makeDirectory(public_path("files"), 0777, true, true);
            }

            $path_ = pathinfo($path);

            $file = File::copy($path, public_path("files")."\\".$path_['basename']);

            $file =public_path("files\\{$path_['basename']}");
             $_info=$this->getBrowserInfo();
            LogsFileDownload::dispatch($file_server->id,false, $this->getClientId,$_info['device'],$_info['browser'],$_info['OS']);

            return $file;
        } catch (ModelNotFoundException $exception) {
           \Log::warning($exception->getMessage());
             $message=serialize(["line"=>$exception->getLine(),
                      "file"=>$exception->getFile(),
                    "message"=>$exception->getMessage()]);
            LogsApplication::dispatch("DownloadController","copyFiletoDownload",$message);
            throw new \App\Exceptions\CustomException($exception->getMessage());
        }catch (\Exception $e) {
             \Log::warning($e->getMessage());
              $message=serialize(["line"=>$e->getLine(),
                      "file"=>$e->getFile(),
                    "message"=>$e->getMessage()]);
            LogsApplication::dispatch("DownloadController","copyFiletoDownload",$message);
            throw new \Exception($e->getMessage(), 1);
        }

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
}
