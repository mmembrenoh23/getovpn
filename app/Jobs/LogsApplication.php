<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Model\LogApp;
use Illuminate\Support\Facades\Log;

class LogsApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $_window;
    private $_action;
    private $_message;
    private $_user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($_window, $_action, $_message,$_user_id)
    {
        $this->_window=$_window;
        $this->_action=$_action;
        $this->_message=$_message;
        $this->_user_id=$_user_id;

        \Log::info("{$this->_window},{$this->_action}, {$this->_message},{$this->_user_id}");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $log = new LogApp();

       $log->window = $this->_window;
       $log->action = $this->_action;
       $log->message = $this->_message;
       $log->user_id = $this->_user_id;

       if($log->save()){
            \Log::info("salvado");
           return 1;
       }
 \Log::info("no salvado");
       return -1;

    }
}

