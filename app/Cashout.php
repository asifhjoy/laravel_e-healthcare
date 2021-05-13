<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashout extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email','method','recipient','amount','date','time',
    ];
}
