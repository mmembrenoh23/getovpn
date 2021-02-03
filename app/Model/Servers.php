<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $filliable=['path','server_name'];

    public function files(){
        return $this->hasMany(Server::class,'server_id');
    }
}
