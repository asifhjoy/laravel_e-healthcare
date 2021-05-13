<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $table = 'week_days';
    public $timestamps = false;

    protected $fillable = [
        'email',
    ];
}
