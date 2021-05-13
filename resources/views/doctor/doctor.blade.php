@extends('layouts.dashlayout')


@section('title')
    <title>Dashboard</title>
@endsection


@section('content')


    <center>
    @if(!$completed)
        <div class="w3-panel w3-hover-shadow" style="width: 50%">
            <form action="newdoctor" method="POST">
                @csrf
            <ul class="w3-ul">
                <li class="w3-padding-16 w3-large">Congratulations!</li>
                <li class="w3-padding-16 w3-large">You request to join as a Doctor has been accepted.</li>
                <li class="w3-padding-16 w3-large"> As a token of Gratitude we offer you a 100 TK credit to your Account.</li>
                <li class="w3-padding-16 w3-large"> Fill out the following form appropriately to claim your Credit.</li>
                <li class="w3-padding-16 w3-large"> Without Providing the following information you will not be shown in our Doctor Roaster.</li>
                <li class="w3-padding-16 w3-large">
                    <input class="w3-input" name="link" type="text" placeholder="Zoom Meeting Link" required>
                </li>
                <li class="w3-padding-16 w3-large">
                    <input class="w3-input" name="code" type="text" placeholder="Meeting Room Code" required>
                </li>
                <li class="w3-padding-16 w3-large">
                    <input class="w3-input" name="pw" type="text" placeholder="Meeting Password" required>
                </li>

                <li class="w3-padding-16 w3-large">
                        <button class="w3-button w3-black w3-hover-teal">Claim Now!</button>
                </li>
            </ul>
         </form>
        </div>
        @else
        @include('clock')

            <div class="container">

                <div class='w3-container' style="padding-left: 100px">

                    <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
                        <table class="w3-table">
                            <tr>
                                <th colspan="3" class="w3-center w3-black">Appointments Statistics</th>
                            </tr>
                            <tr>
                                <th>
                                    Ongoing Appointments
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Appointment::where([['docmail',\Illuminate\Support\Facades\Auth::user()->email],['attended','0'],['unattended','0'],['cancelled','0']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Attended Appointments
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Appointment::where([['docmail',\Illuminate\Support\Facades\Auth::user()->email],['attended','1'],['unattended','0'],['cancelled','0']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Unattended Appointments
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Appointment::where([['docmail',\Illuminate\Support\Facades\Auth::user()->email],['attended','0'],['unattended','1'],['cancelled','0']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Cancelled Appointments
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Appointment::where([['docmail',\Illuminate\Support\Facades\Auth::user()->email],['attended','0'],['unattended','0'],['cancelled','1']])->count()}}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
                        <table class="w3-table">
                            <tr>
                                <th colspan="3" class="w3-center w3-black">Topup / Cashout Statistics</th>
                            </tr>
                            <tr>
                                <th>
                                    Top Ups
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\TopUp::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['verified','1']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Top Ups Amount
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\TopUp::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['verified','1']])->sum('amount')}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Cash Outs
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Cashout::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['verified','1']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Cash Outs Amount
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Cashout::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['verified','1']])->sum('amount')}}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
                <br>

                <div class='w3-container' style="padding-left: 100px">

                    <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
                        <table class="w3-table">
                            <tr>
                                <th colspan="3" class="w3-center w3-black">Balance Inquiry</th>
                            </tr>
                            <tr>
                                <th>
                                    Credit Amount
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['type','Credit']])->sum('amount')}}

                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Debit Amount
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['type','Debit']])->sum('amount')}}

                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Gross Total
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['type','Credit']])->sum('amount') - \App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['type','Debit']])->sum('amount')}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Current Balance
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Balance::where('email',\Illuminate\Support\Facades\Auth::user()->email)->value('balance')}}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
                        <table class="w3-table">
                            <tr>
                                <th colspan="3" class="w3-center w3-black">Transaction Statistics</th>
                            </tr>
                            <tr>
                                <th>
                                    Today's Transactions
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['date',\Carbon\Carbon::today()]])->count()}}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Credit Transactions
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['type','Credit']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Debit Transactions
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where([['email',\Illuminate\Support\Facades\Auth::user()->email],['type','Debit']])->count()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Total Transactions
                                </th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{\App\Transaction::where('email',\Illuminate\Support\Facades\Auth::user()->email)->count()}}
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>


            </div>



        @endif



    </center>
@endsection

