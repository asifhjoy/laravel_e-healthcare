<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Cashout;
use App\TopUp;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    protected function topupview()
    {
        $topup = TopUp::where('email',Auth::user()->email)->orderBy('date','desc')->orderBy('time','desc')->get();

        return view('topup',compact('topup'));
    }

    protected function verifytopup(Request $r)
    {
        $transaction = new Transaction();

        $transaction->email = $r->email;
        $transaction->date = $r->date;
        $transaction->time = $r->time;
        $transaction->type = 'Credit';
        $transaction->description = $r->description;
        $transaction->amount = $r->amount;

        $balance = Balance::where('email',$r->email)->value('balance');

        Balance::where('email',$r->email)->update(['balance'=>floatval($balance)+floatval($r->amount)]);
        TopUp::where('id',$r->id)->update(['verified'=>1]);
        $transaction->save();

        return redirect()->back();

    }

    protected function rejecttopup(Request $r)
    {
        TopUp::where('id',$r->id)->delete();

        return redirect()->back();
    }

    protected function transactions(Request $r)
    {
        $trans='';
        $page=10;
        $sort='desc';
        $type='';
        $dt = Transaction::where('email',Auth::user()->email)->select('date')->distinct()->get();
        $count = Transaction::where('email',Auth::user()->email)->count();

        if($r->date || $r->type)
        {
            $count =1;
            if($r->date && $r->type)
            {
                $trans = Transaction::where('email',Auth::user()->email)->where('type',$r->type)->where('date',$r->date)->orderBy('date',$sort)->orderBy('time',$sort)->paginate(100);
                return view('transactions',compact('trans','dt','count'));
            }

            if($r->date)
            {
                $trans = Transaction::where('email',Auth::user()->email)->where('date',$r->date)->orderBy('date',$sort)->orderBy('time',$sort)->paginate(100);
                return view('transactions',compact('trans','dt','count'));
            }
            if($r->type)
            {
                $trans = Transaction::where('email',Auth::user()->email)->where('type',$r->type)->orderBy('date',$sort)->orderBy('time',$sort)->paginate(100);
                return view('transactions',compact('trans','dt','count'));
            }


        }

            $trans = Transaction::where('email',Auth::user()->email)->orderBy('date',$sort)->orderBy('time',$sort)->paginate($page);
            return view('transactions',compact('trans','dt','count'));



    }

    protected function verifycashout(Request $r)
    {
        $transaction = new Transaction();

        $transaction->email = $r->email;
        $transaction->date = $r->date;
        $transaction->time = $r->time;
        $transaction->type = 'Debit';
        $transaction->description = $r->description;
        $transaction->amount = $r->amount;

        $balance = Balance::where('email',$r->email)->value('balance');

        Balance::where('email',$r->email)->update(['balance'=>floatval($balance)-floatval($r->amount)]);
        Cashout::where('id',$r->id)->update(['verified'=>1]);
        $transaction->save();

        return redirect()->back();

    }

    protected function all(Request $r)
    {
        $dt = Transaction::select('date')->distinct()->get();
        $count  = Transaction::all()->count();


        if(Auth::user()->utype=='Admin')
        {
            if($r->date || $r->email)
            {
                if($r->date && $r->email)
                {
                    $trans = Transaction::where('email',$r->email)->where('date',$r->date)->orderBy('date','desc')->orderBy('time','desc')->paginate(100);
                    return view('transactions',compact('trans','dt','count'));
                }
                if($r->date)
                {
                    $trans = Transaction::where('date',$r->date)->orderBy('date','desc')->orderBy('time','desc')->paginate(100);
                    return view('transactions',compact('trans','dt','count'));
                }
                if($r->email)
                {
                    $trans = Transaction::where('email',$r->email)->orderBy('date','desc')->orderBy('time','desc')->paginate(100);
                    return view('transactions',compact('trans','dt','count'));
                }
            }
            else
            {
                $trans = Transaction::orderBy('date','desc')->orderBy('time','desc')->paginate(10);

                return view('transactions',compact('dt','trans','count'));
            }

        }

        return redirect('/');

    }


}
