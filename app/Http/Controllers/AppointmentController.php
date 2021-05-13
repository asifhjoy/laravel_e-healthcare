<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Balance;
use App\Doctor;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
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

    protected function makeappointment($email)
    {
        $doctor = DB::table('doctors')
            ->where('doctors.email','=',$email)
            ->join('users','doctors.email','=','users.email')
            ->join('week_days','week_days.email','=','doctors.email')
            ->join('departments','doctors.department','=','departments.dptcode')
            ->select('users.name','users.pic','users.gender','users.bday','users.phone','doctors.*','week_days.*','departments.*')
            ->get();

        $dt = Appointment::where('docmail',$email)->where('cancelled','0')->get();
        $reschedule = 0;


        return view('client.makeappointment',compact('doctor','dt','reschedule'));
    }



    protected function confirmappointment(Request $r)
    {
        $masteraccount = Balance::where('email','account@e-healthcare.com')->exists();
        if(!$masteraccount)
        {
            $master = new Balance();

            $master->email = 'account@e-healthcare.com';
            $master->balance = 0;

            $master->save();
        }

        $clienttransaction_id = '';
        $doctransaction_id = '';

        $clienttransaction = new Transaction();
        $doctransaction = new Transaction();
        $mastertransaction = new Transaction();

        $clienttransaction->email = Auth::user()->email;
        $clienttransaction->date = Carbon::today();
        $clienttransaction->time = Carbon::now();
        $clienttransaction->type = 'Debit';
        $clienttransaction->description = 'payment to '.$r->docmail;
        $clienttransaction->amount = $r->amount;

        if($clienttransaction->save())
        {
            $clienttransaction_id = $clienttransaction->id;
        }

        $doctransaction->email = $r->docmail;
        $doctransaction->date = Carbon::today();
        $doctransaction->time = Carbon::now();
        $doctransaction->type = 'Credit';
        $doctransaction->description = 'payment from '.Auth::user()->email;
        $doctransaction->amount = floatval($r->amount)-(floatval($r->amount)*0.10);

        if($doctransaction->save())
        {
            $doctransaction_id = $doctransaction->id;
        }

        $mastertransaction->email = 'account@e-healthcare.com';
        $mastertransaction->date = Carbon::today();
        $mastertransaction->time = Carbon::now();
        $mastertransaction->type = 'Credit';
        $mastertransaction->description = 'Doctor : '.$r->docmail.' Client : '.Auth::user()->email ;
        $mastertransaction->amount = (floatval($r->amount)*0.10);

        $mastertransaction->save();

       $clientbalance  = Balance::where('email',Auth::user()->email)->value('balance');
       $clientbalance= $clientbalance-$r->amount;
        Balance::where('email',Auth::user()->email)->update(['balance'=>$clientbalance]);


       $docbalance = Balance::where('email',$r->docmail)->value('balance');
       $docbalance= $docbalance+(($r->amount)-($r->amount)*.10);
        Balance::where('email',$r->docmail)->update(['balance'=>$docbalance]);

        $masterbalance = Balance::where('email','account@e-healthcare.com')->value('balance');
        $masterbalance = $masterbalance + (($r->amount)*.10);
        Balance::where('email','account@e-healthcare.com')->update(['balance'=>$masterbalance]);


       $appointment = new Appointment();

       $datetime = explode(',',$r->datetime);

       $appointment->transaction_doc = $doctransaction_id;
       $appointment->transaction_client = $clienttransaction_id;
       $appointment->docmail = $r->docmail;
        $appointment->clientmail = Auth::user()->email;
        $appointment->appointed_date = $datetime[0];
        $appointment->appointed_time = $datetime[1];
        $appointment->attended = 0;
        $appointment->unattended = 0;

        if($appointment->save())
        {
            Appointment::where('id',$appointment->id)->update(['appointment'=>'app'.$appointment->id]);
        };

        return redirect('/appointmentsreport');

    }
    protected function rescheduleappointment($email,$appointment)
    {
        $doctor = DB::table('doctors')
            ->where('doctors.email','=',$email)
            ->join('users','doctors.email','=','users.email')
            ->join('week_days','week_days.email','=','doctors.email')
            ->join('departments','doctors.department','=','departments.dptcode')
            ->select('users.name','users.pic','users.gender','users.bday','users.phone','doctors.*','week_days.*','departments.*')
            ->get();

        $dt = Appointment::where('docmail',$email)->where('cancelled','0')->get();
        $reschedule  = 1;


        return view('client.makeappointment',compact('doctor','dt','reschedule','appointment'));
    }

    protected function confirmreschedule(Request $r)
    {
        $clienttransaction = new Transaction();
        $doctransaction = new Transaction();
        $mastertransaction = new Transaction();


        $clienttransaction->email = Auth::user()->email;
        $clienttransaction->date = Carbon::today();
        $clienttransaction->time = Carbon::now();
        $clienttransaction->type = "Debit";
        $clienttransaction->description = 'Fee for Rescheduling of '.$r->docmail;
        $clienttransaction->amount = $r->amount*0.2;

        $doctransaction->email = $r->docmail;
        $doctransaction->date = Carbon::today();
        $doctransaction->time = Carbon::now();
        $doctransaction->type = "Credit";
        $doctransaction->description = 'Fee for Rescheduling from '.Auth::user()->email;
        $doctransaction->amount = $r->amount*0.1;

        $mastertransaction->email = 'account@e-healthcare.com';
        $mastertransaction->date = Carbon::today();
        $mastertransaction->time = Carbon::now();
        $mastertransaction->type = "Credit";
        $mastertransaction->description = 'Fee for Rescheduling '.$r->appid;
        $mastertransaction->amount = $r->amount*0.1;


        $clientbalance = Balance::where('email',Auth::user()->email)->value('balance');
        $clientbalance = $clientbalance - $r->amount*0.2;
        Balance::where('email',Auth::user()->email)->update(['balance'=>$clientbalance]);

        $docbalance = Balance::where('email',$r->docmail)->value('balance');
        $docbalance = $docbalance + $r->amount*0.1;
        Balance::where('email',$r->docmail)->update(['balance'=>$docbalance]);

        $masterbalance = Balance::where('email','account@e-healthcare.com')->value('balance');
        $masterbalance = $masterbalance + $r->amount*0.1;
        Balance::where('email','account@e-healthcare.com')->update(['balance'=>$masterbalance]);

        $clienttransaction->save();
        $doctransaction->save();
        $mastertransaction->save();

        $datetime = explode(',',$r->datetime);

        Appointment::where('appointment',$r->appid)->update(['appointed_date'=>$datetime[0],'appointed_time'=>$datetime[1]]);

        return redirect('/appointmentsreport')->with('success','Appointment Rescheduled');

    }

    protected function appreport()
    {
        $pending='';
        $completed='';
        $unattended='';
        $cancelled='';



        Appointment::where('appointed_date','<',Carbon::today())->where('attended',0)->update(['unattended'=>1]);

        if(Auth::user()->utype=='Client')
        {
            $pending = DB::table('appointments')
                    ->where('clientmail',Auth::user()->email)
                    ->where('unattended','=',0)
                    ->where('attended','=',0)
                    ->where('cancelled','=',0)
                    ->join('doctors','doctors.email','=','appointments.docmail')
                    ->join('users','users.email','=','appointments.docmail')
                    ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                    ->get();

            $completed = DB::table('appointments')
                ->where('clientmail',Auth::user()->email)
                ->where('attended','=',1)
                ->join('doctors','doctors.email','=','appointments.docmail')
                ->join('users','users.email','=','appointments.docmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();

            $unattended=DB::table('appointments')
                ->where('clientmail',Auth::user()->email)
                ->where('unattended','=',1)
                ->join('doctors','doctors.email','=','appointments.docmail')
                ->join('users','users.email','=','appointments.docmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();

            $cancelled=DB::table('appointments')
                ->where('clientmail',Auth::user()->email)
                ->where('cancelled','=',1)
                ->join('doctors','doctors.email','=','appointments.docmail')
                ->join('users','users.email','=','appointments.docmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();
        }
        if(Auth::user()->utype=='Doctor')
        {
            $pending = DB::table('appointments')
                ->where('docmail',Auth::user()->email)
                ->where('unattended','=',0)
                ->where('attended','=',0)
                ->where('cancelled','=',0)
                ->join('users','users.email','=','appointments.clientmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();

            $completed = DB::table('appointments')
                ->where('docmail',Auth::user()->email)
                ->where('attended','=',1)
                ->join('users','users.email','=','appointments.clientmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();

            $unattended=DB::table('appointments')
                ->where('docmail',Auth::user()->email)
                ->where('unattended','=',1)
                ->join('users','users.email','=','appointments.clientmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();

            $cancelled=DB::table('appointments')
                ->where('docmail',Auth::user()->email)
                ->where('cancelled','=',1)
                ->join('users','users.email','=','appointments.clientmail')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();


        }



        return view('appreport',compact('pending','completed','unattended','cancelled'));
    }

    protected function details($appid)
    {
        $data='';

        $clientauthmail = Appointment::where('appointment',$appid)->value('clientmail');
        $docauthmail = Appointment::where('appointment',$appid)->value('docmail');


        if(Auth::user()->email==$clientauthmail)
        {
            $data = DB::table('appointments')
                ->where('appointment',$appid)
                ->join('doctors','doctors.email','=','appointments.docmail')
                ->join('users','users.email','=','appointments.docmail')
                ->join('departments','doctors.department','=','departments.dptcode')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();
        }
        elseif(Auth::user()->email==$docauthmail)
        {
            $data = DB::table('appointments')
                ->where('appointment',$appid)
                ->join('doctors','doctors.email','=','appointments.docmail')
                ->join('users','users.email','=','appointments.clientmail')
                ->join('departments','doctors.department','=','departments.dptcode')
                ->orderBy('appointed_date','asc')->orderBy('appointed_time','asc')
                ->get();

        }



        return view('appdetails',compact('data'));
    }

    protected function cancelappointment(Request $r)
    {


        $docmail = Appointment::where('appointment',$r->appid)->value('docmail');
        $clientmail = Appointment::where('appointment',$r->appid)->value('clientmail');
        $docrate = Doctor::where('email',$docmail)->value('rate');



        $doctransaction = new Transaction();
        $clienttransaction = new Transaction();
        $mastertransaction = new Transaction();

        if(Auth::user()->email==$clientmail) {

            if ($r->flag == 0) {
                $doctransaction->email = $docmail;
                $doctransaction->date = Carbon::today();
                $doctransaction->time = Carbon::now();
                $doctransaction->type = 'Debit';
                $doctransaction->description = $clientmail . ' Cancelled Appointment. 60% Refunded to client';
                $doctransaction->amount = $docrate * 0.6;

                $clienttransaction->email = $clientmail;
                $clienttransaction->date = Carbon::today();
                $clienttransaction->time = Carbon::now();
                $clienttransaction->type = 'Credit';
                $clienttransaction->description = 'Cancelled Appointment of ' . $docmail . '. 50% Refunded';
                $clienttransaction->amount = $docrate * 0.5;

                $mastertransaction->email = 'account@e-healthcare.com';
                $mastertransaction->date = Carbon::today();
                $mastertransaction->time = Carbon::now();
                $mastertransaction->type = 'Credit';
                $mastertransaction->description = $clientmail . ' Cancelled Appointment of ' . $docmail;
                $mastertransaction->amount = $docrate * 0.1;

                $clientbalance = Balance::where('email', $clientmail)->value('balance');
                $clientbalance = $clientbalance + ($docrate * 0.5);
                Balance::where('email', $clientmail)->update(['balance' => $clientbalance]);


                $docbalance = Balance::where('email', $docmail)->value('balance');
                $docbalance = $docbalance - $docrate * 0.6;
                Balance::where('email', $docmail)->update(['balance' => $docbalance]);

                $masterbalance = Balance::where('email', 'account@e-healthcare.com')->value('balance');
                $masterbalance = $masterbalance + ($docrate * .10);
                Balance::where('email', 'account@e-healthcare.com')->update(['balance' => $masterbalance]);

                Appointment::where('appointment', $r->appid)->update(['cancelled' => 1]);

                $doctransaction->save();
                $clienttransaction->save();
                $mastertransaction->save();

                return redirect('/appointmentsreport')->with('success', 'Appointment Cancelled with 50% Refund');
            }
            if ($r->flag == 1) {

                Appointment::where('appointment', $r->appid)->update(['cancelled' => 1]);

                return redirect('/appointmentsreport')->with('success', 'Appointment Cancelled with NO Refund');

            }
        }
        if(Auth::user()->email==$docmail)
        {
            $doctransaction->email = $docmail;
            $doctransaction->date = Carbon::today();
            $doctransaction->time = Carbon::now();
            $doctransaction->type = 'Debit';
            $doctransaction->description = 'You Cancelled the Appointment with '.$clientmail. '. 120% of your visiting rate deducted';
            $doctransaction->amount = $docrate * 1.2;

            $clienttransaction->email = $clientmail;
            $clienttransaction->date = Carbon::today();
            $clienttransaction->time = Carbon::now();
            $clienttransaction->type = 'Credit';
            $clienttransaction->description = $docmail .' Cancelled your appointment. 110% of visiting rate refunded to your account.';
            $clienttransaction->amount = $docrate * 1.1;

            $mastertransaction->email = 'account@e-healthcare.com';
            $mastertransaction->date = Carbon::today();
            $mastertransaction->time = Carbon::now();
            $mastertransaction->type = 'Credit';
            $mastertransaction->description = $docmail . ' Cancelled Appointment with ' . $clientmail;
            $mastertransaction->amount = $docrate * 0.1;

            $clientbalance = Balance::where('email', $clientmail)->value('balance');
            $clientbalance = $clientbalance + ($docrate * 1.1);
            Balance::where('email', $clientmail)->update(['balance' => $clientbalance]);


            $docbalance = Balance::where('email', $docmail)->value('balance');
            $docbalance = $docbalance - $docrate * 1.2;
            Balance::where('email', $docmail)->update(['balance' => $docbalance]);

            $masterbalance = Balance::where('email', 'account@e-healthcare.com')->value('balance');
            $masterbalance = $masterbalance + ($docrate * 0.1);
            Balance::where('email', 'account@e-healthcare.com')->update(['balance' => $masterbalance]);

            Appointment::where('appointment', $r->appid)->update(['cancelled' => 1]);

            $doctransaction->save();
            $clienttransaction->save();
            $mastertransaction->save();

            return redirect('/appointmentsreport')->with('success', 'Appointment Cancelled with 120% refund to client');

        }
    }

    protected function flagasattended($appointment)
    {
        Appointment::where('appointment',$appointment)->update(['attended'=>1]);

        return redirect('/appointmentsreport')->with('success', 'Appointment Marked as Attended');
    }

    protected function allappointments(Request $r)
    {
        $count = Appointment::all()->count();

        if($r->app)
        {
            $data = Appointment::where('appointment',$r->app)->paginate(1);
        }
        else
        {
            $data = Appointment::paginate(25);
        }

        return view('allappointments',compact('data','count'));

    }



}
