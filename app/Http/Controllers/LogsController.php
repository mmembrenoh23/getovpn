<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\LogApp;
use App\Model\LogFile;
use App\Jobs\LogsApplication;
use Exception;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function index(){

        return view("admin.logs.log");
    }

    public function getAllLogApp(){
        if(request()->ajax()){
            try {

                $Logs = LogApp::paginate(10);
                $Logs->withPath(route('logs-app'));

                LogsApplication::dispatch("LogsController","getAllLogApp","Getting All app logs. Total logs ".$Logs->count(),Auth::guard('admin')->user()->id);

                return $Logs;

            } catch (\Throwable $th) {
                LogsApplication::dispatch("LogsController","getAllLogApp",$th->getMessage(),Auth::guard('admin')->user()->id);
                 throw new Exception($th->getMessage());
            }


        }
    }

    public function getAllLogFile(){
        if(request()->ajax()){
            try {

                $Logs = LogFile::paginate(10);
                $Logs->withPath(route('logs-file'));

                LogsApplication::dispatch("LogsController","getAllLogFile","Getting All file downloaded logs. Total logs ".$Logs->count(),Auth::guard('admin')->user()->id);

                return $Logs;

            } catch (\Throwable $th) {
               LogsApplication::dispatch("LogsController","getAllLogApp",$th->getMessage(),Auth::guard('admin')->user()->id);
               throw new Exception($th->getMessage());
            }
        }
    }
}
