<?php

namespace App\Jobs;

use App\Model\LogFile;
use App\Model\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogsFileDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $_file_id;
    public $_is_admin;
    public $_admin_id;
    private $_ip;
    private $_device;
    private $_browser;
    private $_OS;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($_file_id, $_is_admin,$_ip,$_device,$_browser,$_OS, $_admin_id=0)
    {
        $this->_file_id=$_file_id;
        $this->_is_admin=$_is_admin;
        $this->_admin_id=$_admin_id;
        $this->_ip=$_ip;
        $this->_device=$_device;
        $this->_browser=$_browser;
        $this->_OS=$_OS;

         \Log::info("{$this->_file_id},{$this->_is_admin}, {$this->_admin_id},
          {$this->_ip}, {$this->_device}, {$this->_browser}, {$this->_OS}");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $logFile = new LogFile();

        $logFile->server_file_id = $this->_file_id;
        $logFile->OS = $this->_OS;
        $logFile->browser = $this->_browser;
        $logFile->device = $this->_device;
        $logFile->ip = $this->_ip;

        if($this->_is_admin){

            $logFile->is_admin = true;
            if($logFile->save()){
                $logFile->userAdmin()->attach($this->_admin_id ,["created_at"=>date('Y-m-d H:i:s')]);
                return 0;
            }

        }
        else{
            $logFile->is_admin = false;

            if($logFile->save()){
                return 0;
            }
        }

        return -1;
    }
}
