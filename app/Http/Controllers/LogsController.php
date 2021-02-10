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

    public function getAllLogApp(Request $request){
        if(request()->ajax()){
            try {

                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

              //  $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
               // $order_arr = $request->get('order');
                $search_arr = $request->get('search');

               // $columnIndex = $columnIndex_arr[0]['column']; // Column index
              //  $columnName = $columnName_arr[$columnIndex]['data']; // Column name
               // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                $Logs = LogApp::paginate(10);
                $Logs->withPath(route('logs-app'));

                $totalRecords = LogApp::select('count(*) as allcount')->count();
                $totalRecordswithFilter =
                    LogApp::select('count(*) as allcount')
                        ->where('message', 'like', '%' .$searchValue . '%')
                        ->orWhere('action', 'like', '%' .$searchValue . '%')
                        ->orWhere('window', 'like', '%' .$searchValue . '%')
                        ->orWhere('users.first_name', 'like', '%' .$searchValue . '%')
                        ->orWhere('users.last_name', 'like', '%' .$searchValue . '%')
                        ->join('users', 'users.id', '=', 'logs_app.user_id')
                        ->orderBy('logs_app.id','desc')
                        ->count();


                // Fetch records
                $records = LogApp::where('message', 'like', '%' .$searchValue . '%')
                    ->orWhere('action', 'like', '%' .$searchValue . '%')
                    ->orWhere('window', 'like', '%' .$searchValue . '%')
                    ->orWhere(\DB::raw("concat(users.first_name,' ',users.last_name)"), 'like', '%' .$searchValue . '%')
                    ->join('users', 'users.id', '=', 'logs_app.user_id')
                    ->select('logs_app.id','message','action','window',\DB::raw("concat(users.first_name,' ',users.last_name) as fullname"),'logs_app.created_at')
                    ->orderBy('logs_app.id','desc')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

                $data_arr = array();

                foreach($records as $record){
                    $data = @unserialize($record->message);
                    $message=$record->message;
                    if ($data !== false) {
                        $message="";
                        foreach($data as $key => $value){
                            $message .="$key: $value <br>";
                        }
                    }

                    $data_arr[] = array(
                    "id" => $record->id,
                    "message" => $message,
                    "action" => $record->action,
                    "window" => $record->window,
                    "fullname" => $record->fullname,
                    "date" => \Carbon\Carbon::parse($record->created_at)->format('F j, Y'),
                    );
                }

                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );

                LogsApplication::dispatch("LogsController","getAllLogApp","Getting All app logs. Total logs ".(count($data_arr)),Auth::guard('admin')->user()->id);

                return response()->json($response);

            } catch (\Throwable $th) {
                LogsApplication::dispatch("LogsController","getAllLogApp",$th->getMessage(),Auth::guard('admin')->user()->id);
                 throw new Exception($th->getMessage());
            }


        }
    }

    public function getAllLogFile(Request $request){
        if(request()->ajax()){
            try {

                 $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

              //  $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
               // $order_arr = $request->get('order');
                $search_arr = $request->get('search');

               // $columnIndex = $columnIndex_arr[0]['column']; // Column index
              //  $columnName = $columnName_arr[$columnIndex]['data']; // Column name
               // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                $Logs = LogFile::paginate(10);
                $Logs->withPath(route('logs-app'));

                $totalRecords = LogFile::select('count(*) as allcount')->count();
                $totalRecordswithFilter =
                    LogFile::select('count(*) as allcount')
                        ->where('OS', 'like', '%' .$searchValue . '%')
                        ->orWhere('browser', 'like', '%' .$searchValue . '%')
                        ->orWhere('device', 'like', '%' .$searchValue . '%')
                        ->orWhere('ip', 'like', '%' .$searchValue . '%')
                        ->orWhere('server_file.name', 'like', '%' .$searchValue . '%')
                        ->join('server_file', 'server_file.id', '=', 'logs_download_file.server_file_id')
                        ->orderBy('logs_download_file.id','desc')
                        ->count();


                // Fetch records
                $records = LogFile::where('OS', 'like', '%' .$searchValue . '%')
                        ->orWhere('browser', 'like', '%' .$searchValue . '%')
                        ->orWhere('device', 'like', '%' .$searchValue . '%')
                        ->orWhere('ip', 'like', '%' .$searchValue . '%')
                        ->orWhere('server_file.name', 'like', '%' .$searchValue . '%')
                        ->join('server_file', 'server_file.id', '=', 'logs_download_file.server_file_id')
                        ->leftJoin('log_file_user', 'logs_download_file_id', '=', 'logs_download_file.id')
                        ->leftJoin('users', 'users.id', '=', 'log_file_user.user_id')
                    ->select('logs_download_file.id','OS','browser','device','ip','server_file.name as file','server_file.owner','is_admin', \DB::raw("concat(users.first_name,' ',users.last_name) as fullname"),'logs_download_file.created_at')
                    ->orderBy('logs_download_file.id','desc')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

                $data_arr = array();

                foreach($records as $record){
                   //'OS','browser','device','ip','server_file.name','server_file.owner','is_admin'

                   $username="N/A";
                   if( $record->is_admin){
                        $username=$record->fullname;
                   }
                    $data_arr[] = array(
                    "id" => $record->id,
                    "OS" => $record->OS,
                    "browser" => $record->browser,
                    "device" => $record->device,
                    "ip" => $record->ip,
                    "name" => $record->file,
                    "fullname" => $username,
                    "date" => \Carbon\Carbon::parse($record->created_at)->format('F j, Y'),
                    );
                }

                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );


                LogsApplication::dispatch("LogsController","getAllLogFile","Getting All file downloaded logs. Total logs ".(count($data_arr)),Auth::guard('admin')->user()->id);

                return response()->json($response);

            } catch (\Throwable $th) {
               LogsApplication::dispatch("LogsController","getAllLogApp",$th->getMessage(),Auth::guard('admin')->user()->id);
               throw new Exception($th->getMessage());
            }
        }
    }
}
