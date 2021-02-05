<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogFile extends Model
{
    protected  $table="logs_download_file";
    protected $filliable =['is_admin','server_file_id','OS','browser','device','ip'];

    public function userAdmin(){
        return $this->belongsToMany(User::class, 'log_file_user', 'logs_download_file_id', 'user_id');
    }
}
