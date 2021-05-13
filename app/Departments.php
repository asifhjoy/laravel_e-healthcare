<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{

    protected $table = 'departments';
    public $timestamps = false;

    protected $fillable = [
        'dptname','dptcode',
    ];
}
