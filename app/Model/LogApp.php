<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogApp extends Model
{
    protected $table="logs_app";

    protected $filliables =['window','action','message'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
