<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balances';
    public $timestamps = false;

    protected $fillable = [
        'email','balance',
        ];

}
