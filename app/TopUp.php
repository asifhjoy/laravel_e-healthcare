<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $table = 'top_ups';
    public $timestamps = false;

    protected $fillable = [
        'email','method','payphone','trxid','amount','date','time',
    ];
}
