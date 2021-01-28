<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

use App\Model\Servers;
use App\Model\Server;

class ProcessVPNFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server_path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($_server_path)
    {
        $this->server_path = $_server_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        \Log::info($this->server_path);
        $files = $this->getDirFiles($this->server_path);

        \Log::info($files);

        if(!empty($files)){
            foreach($files as $file){

                $server = new Server();

                $server->path = $file['file_path'];
                $server->name = $file['file_name'];
                $server->created_file = $file['file_created'];
                $server->size = $file['file_size'];
                $server->server_id = $file['server_id'];

                $server->save();
            }
        }
    }

    private function getDirFiles($_dir){

        $files = [];
        if(is_dir($_dir)){
            if ($dh = opendir($_dir)) {
                while (($file = readdir($dh)) !== false) {
                    if(file_exists("$_dir\\$file")){
                        $fileinfo = pathinfo("$_dir\\$file");
                        $server_path=basename($_dir);

                        $server_id = Servers::where('server_name',$server_path)->first()->id;

                        if(isset($fileinfo['extension']) && !empty($fileinfo['extension'])){
                            $filesize = filesize("$_dir\\$file");

                            $date=\Carbon\Carbon::now();
                            $date->timestamp = filemtime("$_dir\\$file") ;
                            $files[]=[
                                'server_id'=>$server_id,
                                'file_path'=> "$_dir\\$file",
                                'file_name'=>$fileinfo['filename'],
                                'file_size'=>$this->FileSizeConvert($filesize),
                                'file_created'=>$date->format('Y-m-d')
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
                $result = str_replace(".", "," , strval(round($result, 2)));
                break;
            }
        }
        return $result;
    }
}
