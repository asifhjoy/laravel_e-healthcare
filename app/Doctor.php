<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    public $timestamps = false;

    protected $fillable = [
        'email','department','stime','ftime','rate','cv',
    ];
}
