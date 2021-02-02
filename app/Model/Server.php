<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'path', 'name','owner','created_file','size','url_download','secret'
    ];

    protected $table="server_file";

    public function servers(){
        return $this->belongsTo(Servers::class,'server_id');
    }
}
