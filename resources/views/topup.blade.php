@extends('layouts.dashlayout')

<style>

    .placeholder {
        display: none;
    }
</style>


@section('title')
    <title>Top Up</title>
@endsection



@section('header')
    <center> <h5><b>Top Up Account</b></h5></center>
@endsection

@section('content')
    <center>
        @if(session()->has('fail'))
            <div class="w3-panel w3-red">
                <h4> {{session()->get('fail')}}</h4>
            </div>
        @endif

        @if(session()->has('success'))
            <div class="w3-panel w3-green">
                <h4> {{session()->get('success')}}</h4>
            </div>
        @endif
        <div class="w3-container w3-panel" style="width: 50%">
            <table class="w3-table w3-white">
                <tr>
                    <td class="w3-large">1. Make Payment to +880 xxxxxxxxxx.</td>
                </tr>
                <tr>
                    <td class="w3-large">2. Supported Methods : <ul>
                            <li>Bkash</li>
                            <li>Rocket</li>
                            <li>Nagad</li>
                            <li>SureCash</li>
                        </ul></td>
                </tr>
                <tr>
                    <td class="w3-large">2. Use your Email Address as Reference Key during Payment.</td>
                </tr>

            </table>
        </div>
        <hr>
        <div class="w3-panel" style="width: 50%">
            <table class="w3-table w3-white">
                <form action="/topupreq" method="POST">
                    @csrf

                <tr>
                   <td colspan="2">
                       <select class="w3-input" type="text" name="paymethod" required>
                        <option value="0">Select Top Up Method</option>
                        <option value="Bkash">Bkash</option>
                        <option value="Rocket">Rocket</option>
                        <option value="Nagad">Nagad</option>
                        <option value="SureCash">SureCash</option>
                    </select>
                   </td>
                </tr>
                <tr>
                    <td class="w3-center w3-right" style="padding-top: 20px">+880</td>
                    <td><input class="w3-input" name="payphone" type="number" placeholder="Payment Phone Number" required style="padding-left: 60px"> </td>
                </tr>
                <tr>
                    <td colspan="2"><input class="w3-input" name="trx" type="text" placeholder="Transaction ID" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="w3-input" name="amount" type="text" placeholder="Payment Amount" required></td>
                </tr>

                    <tr>
                        <input type="hidden" name="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                        <td colspan="2"><button class="w3-button w3-black w3-hover-teal w3-right">Submit</button></td>
                    </tr>
                </form>
            </table>

        </div>

            <hr>

            <h5><button class="w3-button w3-block w3-black w3-hover-teal" id="clickme" style="width: 48%">Top Up History</button></h5><br>

            <div class="w3-container w3-panel placeholder" id="displaytable" style="width: 50%">

                <table class="w3-table w3-white w3-striped w3-hoverable content" id="displaytable2">
                    <tr>
                    <th class="w3-center">Method</th>
                    <th class="w3-center">Payment Number</th>
                    <th class="w3-center">Transaction ID</th>
                    <th class="w3-center">Date</th>
                    <th class="w3-center">Time</th>
                    <th class="w3-center">Amount</th>
                    <th class="w3-center">Status</th>
                    </tr>
                    @foreach($topup as $top)
                        <tr>
                            <td class="w3-center">{{$top->method}}</td>
                            <td class="w3-center">{{$top->payphone}}</td>
                            <td class="w3-center">{{$top->trxid}}</td>
                            <td class="w3-center">{{date('d-m-Y',strtotime($top->date))}}</td>
                            <td class="w3-center">{{date('h:i:s A',strtotime($top->time))}}</td>
                            <td class="w3-center">{{$top->amount}}</td>
                            <td class="w3-center">
                                @if($top->verified==1)
                                    Verified
                                @else
                                    Pending
                                 @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        <hr>



    </center>

    <script>
        var click = document.getElementById('clickme');
        click.addEventListener('click', myfunction);

        function myfunction() {
            var tablewrap = document.getElementById('displaytable');
            tablewrap.classList.toggle('placeholder')
        }


    </script>
@endsection


