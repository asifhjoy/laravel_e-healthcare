<?php

namespace App\Http\Controllers;

use App\Departments;
use App\Doctor;
use App\User;
use App\WeekDays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class DoctorController extends Controller
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

    function docinfo(Request $r)
    {
        $days =  new WeekDays();

        $days->email = Auth::user()->email;

        if($r->sat||$r->sun||$r->mon||$r->tues||$r->wed||$r->thurs||$r->fri)
        {
            $days->sat = $r->sat;
            $days->sun = $r->sun;
            $days->mon = $r->mon;
            $days->tues = $r->tues;
            $days->wed = $r->wed;
            $days->thurs = $r->thurs;
            $days->fri = $r->fri;
        }

        else
        {
            return redirect()->back()->with('fail','No Visiting Days Selected!!!');
        }


        $doc = new Doctor();

        $doc->email = Auth::user()->email;
        $doc->department = $r->department;

        $docount  = Departments::where('dptcode',$r->department)->value('total_doc');
        Departments::where('dptcode',$r->department)->update(['total_doc'=>intval($docount)+1]);

        if($r->stime<$r->ftime)
        {
            $doc->stime = $r->stime;
            $doc->ftime = $r->ftime;
        }
        else
        {
            return redirect()->back()->with('fail','Finishing Time can not be equal to or earlier than Starting Time!!! Please select proper Visiting Hours');
        }

        $doc->rate = $r->rate;
        $doc->cv =Auth::user()->email.'.pdf' ;

        if($r->hasFile('cv'))
        {
            $r->cv->storeAs('cv',Auth::user()->email.'.pdf','public');
        }

        $doc->requested = 1;
        $doc->active = 0;

        $doc->save();
        $days->save();


        return redirect('/home');

    }

    function docrequests()
    {
        $data = DB::table('doctors')
                ->where('doctors.requested','=',1)
                ->where('doctors.active','=',0)
                ->join('users','users.email','=','doctors.email')
                ->join('week_days','week_days.email','=','doctors.email')
                ->join('departments','doctors.department','=','departments.dptcode')
                ->paginate(10);

        $count = DB::table('doctors')
            ->where('doctors.requested','=',1)
            ->where('doctors.active','=',0)
            ->join('users','users.email','=','doctors.email')
            ->join('week_days','week_days.email','=','doctors.email')
            ->join('departments','doctors.department','=','departments.dptcode')
            ->count();

        return view('doctor.requests',compact('data','count'));

    }

    function activedocs(Request $r)
    {

        $departments = Departments::all();
        $count = Doctor::all()->count();


        if($r->dpt)
        {
            $count = 1;
            $doctors = DB::table('doctors')
                ->where('doctors.requested','=',1)
                ->where('doctors.active','=',1)
                ->where('doctors.completed','=',1)
                ->where('doctors.department','=',$r->dpt)
                ->join('users','doctors.email','=','users.email')
                ->join('week_days','week_days.email','=','doctors.email')
                ->join('departments','doctors.department','=','departments.dptcode')
                ->paginate(100);

            return view ('client.doclist',compact('doctors','departments','count'));
        }

            $doctors = DB::table('doctors')
                ->where('doctors.requested','=',1)
                ->where('doctors.active','=',1)
                ->where('doctors.completed','=',1)
                ->join('users','doctors.email','=','users.email')
                ->join('week_days','week_days.email','=','doctors.email')
                ->join('departments','doctors.department','=','departments.dptcode')
                ->paginate(5);

            return view ('client.doclist',compact('doctors','departments','count'));

    }


    function acceptrequest(Request $r)
    {
        Doctor::where('email',$r->email)->update(['active'=>1]);

        return redirect()->back();

    }

    function rejectrequest(Request $r)
    {
        if(Doctor::where('email',$r->email)->value('cv'))
        {
            Storage::delete('/public/cv/'.Doctor::where('email',$r->email)->value('cv'));
        }

        Doctor::where('email',$r->email)->delete();
        WeekDays::where('email',$r->email)->delete();


        return redirect()->back();
    }


}
