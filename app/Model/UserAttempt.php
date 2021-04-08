<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAttempt extends Model
{
    protected $fillable = [
        'username', 'message'
    ];

    protected $table="user_attemps";


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "created_at"=>"timestamp",
        "updated_at"=>"timestamp",
    ];
}
