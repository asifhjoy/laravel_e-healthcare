<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    public $timestamps = false;

    protected $fillable = [
        'transaction_doc','transaction_client','docmail','clientmail','appointed_date','appointed_time',
    ];

}
