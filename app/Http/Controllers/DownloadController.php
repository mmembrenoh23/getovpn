<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Server;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DownloadController extends Controller
{
    public function downloadFile($secret){

         return response()->download($this->copyFiletoDownload($secret));
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

            return $file;
        } catch (ModelNotFoundException $exception) {
           \Log::warning($exception->getMessage());
            throw new \App\Exceptions\CustomException($exception->getMessage());
        }catch (\Exception $e) {
             \Log::warning($e->getMessage());
            throw new \Exception($e->getMessage(), 1);
        }
    }
}
