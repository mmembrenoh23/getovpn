<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

use App\Model\Servers;

class ProcessServers implements ShouldQueue
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
        \Log::info('llega al job');
        $this->server_path = $_server_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        \Log::info('entra en el handler');
        $servers=$this->showDir();

        
        \Log::info($servers);

        if(!empty($servers)){

            foreach($servers as $server){
                $server_ = new Servers();

                $server_->path = $server['dir_path'];
                $server_->server_name = $server['dir_name'];

                $server_->save();
            }

            return 1;
        } 
        
        return -1;
    }

    private function showDir(){

        $_directories =[];

        if(is_dir($this->server_path)){
            if ($dh = opendir($this->server_path)) {
                while (($file = readdir($dh)) !== false) {

                    if (is_dir($this->server_path .'\\'. $file) &&
                     !(Str::of($file)->contains('.')) && !(Str::of($file)->contains('..') )) {
                                        
                        $_directories[]=[
                            'dir_path'=>$this->server_path.'\\'. $file,
                            'dir_name'=>$file
                        ];
                    }
                    
                }
                closedir($dh);
             }
             else{
               \Log::warning('Can\'t open the dir');
             }

        }
        else{
            \Log::warning('dir doesn\'t exist');
        }

        return $_directories;
    }
}
