<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Departments;
use App\Doctor;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     *
     */
    public function index()
    {
        $type = Auth::user()->utype;
        if($type=='Admin')
        {
            return view('admin.admin');
        }
        if ($type=='Doctor')
        {
           $doc = Doctor::where('email',Auth::user()->email)->exists();

            if($doc)
            {
               $docac = Doctor::where('email',Auth::user()->email)->value('active');
               $docreq = Doctor::where('email',Auth::user()->email)->value('requested');
               $completed = Doctor::where('email',Auth::user()->email)->value('completed');


                if($docreq && !$docac)
                {
                    return view('doctor.appreview');
                }
                if($docreq && $docac)
                {
                        return view('doctor.doctor',compact('completed'));

                }

            }
            else
            {
                $department = Departments::all();

                return view('doctor.docform',compact('department'));
            }

        }
        if($type=='Client')
        {
            $exist=Balance::where('email',Auth::user()->email)->exists();

            return view('client.client',compact('exist'));


        }
    }

    public function profile()
    {
        if(Auth::user()->utype=="Doctor")
        {
            $data = DB::table('doctors')
                ->where('doctors.email','=',Auth::user()->email)
                ->join('week_days','week_days.email','=','doctors.email')
                ->join('departments','doctors.department','=','departments.dptcode')
                ->select('doctors.*','departments.*','week_days.*')
                ->get();

            return view('profile',compact('data'));
        }

        return view('profile');
    }

    protected function dpupload(Request $r)
    {
        if($r->hasFile('pic'))
        {
            if(auth()->user()->pic)
            {
                Storage::delete('/public/userimages/'.auth()->user()->pic);
            }

            $id = Auth::user()->id;
            $r->pic->store('userimages','public');
            User::find($id)->update(['pic'=>$r->pic->hashName()]);
            return redirect()->back()->with('success','Profile Picture Successfully Uploaded');
        }
        else
        {
            return back()->with('fail','Please Choose a Picture and Try Again');
        }

    }

    protected function dpdel()
    {
        Storage::delete('/public/userimages/'.auth()->user()->pic);
        $id = Auth::user()->id;
        User::find($id)->update(['pic'=>null]);
        return redirect()->back();
    }


}
