<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Mail\AdminRegister;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class AdminRegMailController extends Controller
{


    function sendEmail(Request $r)
    {
        if($r->email==null)
        {
            return redirect()->back()->with('fail','Please Provide an Email');
        }

        Mail::to($r->email)->send(new AdminRegister());
        return redirect()->back()->with('success','Registration Link has been sent to the Provided Email');
    }


    function addadmin(Request $r)
    {
        if(!$r->hasValidSignature())
        {
            abort(401);
        }
        return view('auth.adminregister');
    }

    function firstadmin($key,$email)
    {
        $stat = User::where('utype','Admin')->exists();
        $master = Balance::where('email','account@e-healthcare.com')->exists();

        if(!$stat&&!$master)
        {
            if($key=='secretkey')
            {
                $master_balance = new Balance();

                $master_balance->email = 'account@e-healthcare.com';
                $master_balance->balance = 0;

                $master_balance->save();

                Mail::to($email)->send(new AdminRegister());
                return redirect('/')->with('alert','Operation Executed Successfully');
            }
            else
            {
                return redirect('/')->with('alert','Invalid Key!!!');

            }
        }

        else
        {
            return redirect('/')->with('alert','Forbidden Action!!!');

        }


    }

}
