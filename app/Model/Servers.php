<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    public function servers(){
        return $this->hasMany(Server::class);
    }
}
