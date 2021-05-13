<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Cashout;
use App\Doctor;
use App\TopUp;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
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

    protected function newclient()
    {
        $balance = new Balance();

        $balance->email = Auth::user()->email;
        $balance->balance = 100;

        $transaction = new Transaction();

        $transaction->email = Auth::user()->email;
        $transaction->date = Carbon::today();
        $transaction->time = Carbon::now();
        $transaction->type = 'Credit';
        $transaction->description = 'new account bonus';
        $transaction->amount = 100;

        $balance->save();
        $transaction->save();

        return redirect('/home');

    }

    protected function newdoctor(Request $r)
    {
        $docbalance = new Balance();

        $docbalance->email = Auth::user()->email;
        $docbalance->balance = 100;

        $transaction = new Transaction();

        $transaction->email = Auth::user()->email;
        $transaction->date = Carbon::today();
        $transaction->time = Carbon::now();
        $transaction->type = 'Credit';
        $transaction->description = 'new account bonus';
        $transaction->amount = 100;

        Doctor::where('email',Auth::user()->email)->update(['completed'=>1,'link'=>$r->link,'code'=>$r->code,'pw'=>$r->pw]);


        $docbalance->save();
        $transaction->save();

        return redirect('/home');

    }


    protected function topupreq(Request $r)
    {
        $top = new TopUp();
        if($r->paymethod=='0')
        {
            return redirect()->back()->with('fail','Please Select a Top Up Method');
        }

        $top->email = $r->email;
        $top->method = $r->paymethod;
        $top->payphone = '+880'.intval($r->payphone);
        $top->trxid = $r->trx;
        $top->amount = $r->amount;
        $top->date = Carbon::today();
        $top->time = Carbon::now();
        $top->verified = 0;

        $top->save();

        return redirect()->back()->with('success','An Admin will verify your Top Up details');

    }

    protected function topuprequests()
    {
        $req = TopUp::where('verified',0)->paginate(10);
        $count = TopUp::where('verified',0)->count();

        return view('topuprequests',compact('req','count'));
    }

    protected function cashoutview()
    {
        $cashout = Cashout::where('email',Auth::user()->email)->orderBy('date','desc')->orderBy('time','desc')->get();

        return view('cashout',compact('cashout'));
    }

    protected function cashoutreq(Request $r)
    {
        $balance = Balance::where('email',Auth::user()->email)->value('balance');

        $cout = new Cashout();

        if($r->outmethod=='0')
        {
            return redirect()->back()->with('fail','Please Select a Cashout Method');
        }

        if($balance>$r->amount+50)
        {
            $cout->email = $r->email;
            $cout->method = $r->outmethod;
            $cout->recipient = '+880'.intval($r->recipient);
            $cout->amount = $r->amount;
            $cout->date = Carbon::today();
            $cout->time = Carbon::now();
            $cout->verified = 0;

            $cout->save();

            return redirect()->back()->with('success','An Admin will verify your Cashout Request. This may take up some time. Wait Patiently till you are Notified');
        }
        else
        {
            return redirect()->back()->with('fail','Insufficient Balance. Balance must be at least ৳ 50 after Cashout');
        }
    }

    protected function cashoutrequests()
    {
        $req = Cashout::where('verified',0)->paginate(10);
        $count = Cashout::where('verified',0)->count();

        return view('cashoutrequests',compact('req','count'));
    }

}
