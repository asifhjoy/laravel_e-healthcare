<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\User;
use App\WeekDays;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\AuthorCollectionIterator;
use Illuminate\Support\Facades\Hash;
//use Psy\Util\Str;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function pwchange(Request $r)
    {

        $id = Auth::user()->id;
        $pw = Auth::user()->password;
        $cpw = $r->cpw;
        $npw = $r->npw;
        $rnpw = $r->rnpw;

        if(Hash::check($cpw,$pw))
        {
            if($npw==$rnpw)
            {
                if(strlen($npw)>=8)
                {
                   User::where('id',$id)->update(['password'=> Hash::make($npw)]);
                    return redirect()->back()->with('success','Password Successfully Changed');
                }
                return redirect()->back()->with('fail','Password Length Must be Minimum 8 Character');
            }
            return redirect()->back()->with('fail','Re-Type New Password Correctly');
        }
        return redirect()->back()->with('fail','Current Password did not Match');
    }


    function emailchange(Request $r)
    {
        $id = Auth::user()->id;
        $email = Auth::user()->email;

        if($r->cmail==$email)
        {
            User::where('id',$id)->update(['email' => $r->nmail]);

            if(Auth::user()->utype=='Doctor')
            {
                Doctor::where('email',$email)->update(['email' => $r->nmail]);
                WeekDays::where('email',$email)->update(['email'=> $r->nmail]);
                return redirect()->back()->with('success','Email Successfully Changed');

            }
            return redirect()->back()->with('success','Email Successfully Changed');

        }
        else
        {
            return redirect()->back()->with('fail','Current Email did not Match');
        }

    }

    function savechanges(Request $r)
    {
        $name = $r->name;
        $gender = Str::ucfirst($r->gender);
        $bday = date('Y-m-d', strtotime($r->bday));
        $phone = $r->phone;

        User::where('email',Auth::user()->email)->update(['name'=>$name,'gender'=>$gender,'bday'=>$bday,'phone'=>$phone]);

        return redirect()->back()->with('success','Changes Saved Successfully');


    }

    function update(Request $r)
    {
        $link = $r->link;
        $code = $r->code;
        $pw = $r->pw;

        Doctor::where('email',Auth::user()->email)->update(['link'=>$link,'code'=>$code,'pw'=>$pw]);

        return redirect()->back()->with('success','Information Updated Successfully');

    }


}
