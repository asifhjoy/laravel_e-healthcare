@extends('layouts.dashlayout')


@section('title')
    <title>Transaction History</title>
@endsection


@section('header')
    <center><h5><b>Transaction History</b></h5></center>
@endsection

@section('content')
    @if(!$count)
        <div class="w3-container w3-center" style="height: 58vh">
            <div class="w3-container" style="margin-top: 10%">
                <font color="blue"> <h2><b>No Transactions Occurred Yet</b></h2></font>
            </div>
        </div>
    @else
    @php($flag='')

    @if(\Illuminate\Support\Facades\Auth::user()->utype=='Admin')
        @php($flag=1)
    @else
        @php($flag=0)
    @endif

    @if(!$flag)
    <div class="w3-panel" style="width: 40%; padding-left: 50px">
        <form method="GET" action="/transactions">
            @csrf

        <table class="w3-table w3-white">
            <tr>
                <td>
                    <select class="w3-input" name="date">
                        <option value="0">Select Date</option>
                        @foreach($dt as $data)
                            <option value="{{$data->date}}">{{date('d-m-Y',strtotime($data->date))}}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select class="w3-input" name="type">
                        <option value="0">Select Type</option>
                        <option value="Credit">Credit</option>
                        <option value="Debit">Debit</option>
                    </select>
                </td>


                <td class="w3-center">
                    <button class="w3-button w3-black w3-hover-teal">Go</button>
                </td>
            </tr>
        </table>
        </form>
    </div>
@endif

    @if($flag)
        <div class="w3-panel" style="width: 40%; padding-left: 50px">
            <form method="GET" action="/alltransactions">
                @csrf

                <table class="w3-table w3-white">
                    <tr>
                        <td>
                            <select class="w3-input" name="date">
                                <option value="0">Select Date</option>
                                @foreach($dt as $data)
                                    <option value="{{$data->date}}">{{date('d-m-Y',strtotime($data->date))}}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input class="w3-input" type="text" name="email" placeholder="Search by Email">
                        </td>


                        <td class="w3-center">
                            <button class="w3-button w3-black w3-hover-teal">Go</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        @endif
    <center>
<hr>
        <div class="w3-panel">
            <div class="w3-row-padding w3-margin">

                <table class="w3-table w3-striped w3-hoverable w3-white">

                    <tr>
                        @if($flag)
                        <th class="w3-center">Email</th>
                        @endif
                        <th class="w3-center">Date</th>
                        <th class="w3-center">Time</th>
                        <th class="w3-center">Type</th>
                        <th class="w3-center">Amount</th>
                        <th>Description</th>
                    </tr>

                    @foreach($trans as $r)
                        <tr>
                            @if($flag)
                            <td class="w3-center">{{$r->email}}</td>
                            @endif
                            <td class="w3-center">{{date('d-m-Y',strtotime($r->date))}}</td>
                            <td class="w3-center">{{date('h:i:s  A',strtotime($r->time))}}</td>
                            <td class="w3-center">{{$r->type}}</td>
                            <td class="w3-center">{{$r->amount}}</td>
                            <td>{{ucwords($r->description)}}</td>


                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </center>
    @endif
@endsection

@section('pagination')
    {{ $trans->links() }}
    <hr>
    <hr>
@endsection
