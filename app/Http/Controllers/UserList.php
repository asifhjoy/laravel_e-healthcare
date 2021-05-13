<?php

namespace App\Http\Controllers;


use App\Doctor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserList extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    protected function clientlist(Request $r)
    {
        $client='';
       if(Auth::user()->utype=='Admin')
       {
           if($r->email)
           {
               $clients = User::where('utype','Client')->where('email',$r->email)->paginate(5);
           }
           else
           {
               $clients = User::where('utype','=','Client')->paginate(5);
           }
            $count = User::where('utype','Client')->count();
           return view ('clientlist',compact('clients','count'));
       }

       return redirect('/home');


    }

    protected function doctorlist(Request $r)
    {
        $doctors='';

        if(Auth::user()->utype=='Admin')
        {
            if($r->email)
            {
                $doctors = DB::table('doctors')
                    ->where('doctors.email','=',$r->email)
                    ->where('doctors.requested','=',1)
                    ->where('doctors.active','=',1)
                    ->join('users','doctors.email','=','users.email')
                    ->join('week_days','week_days.email','=','doctors.email')
                    ->join('departments','doctors.department','=','departments.dptcode')
                    ->paginate(5);
            }
            else
            {
                $doctors = DB::table('doctors')
                    ->where('doctors.requested','=',1)
                    ->where('doctors.active','=',1)
                    ->join('users','doctors.email','=','users.email')
                    ->join('week_days','week_days.email','=','doctors.email')
                    ->join('departments','doctors.department','=','departments.dptcode')
                    ->paginate(5);
            }

            $count = Doctor::all()->count();

            return view ('doctorlist',compact('doctors','count'));
        }

        return redirect('/home');

    }

    protected function adminlist()
    {
        if(Auth::user()->utype=='Admin')
        {
            $admins = User::where('utype','=','Admin')->paginate(10);
            $count = User::where('utype','=','Admin')->count();

            return view ('adminlist',compact('admins','count'));
        }

        return redirect('/home');

    }







}
