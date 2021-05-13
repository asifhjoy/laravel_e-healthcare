@extends('layouts.dashlayout')


@section('title')
    <title>Pending Cashouts</title>
@endsection


@section('header')
    <center><h5><b>Cashout Requests</b></h5></center>
@endsection

@section('content')
    <center>
        @if(!$count)
            <div class="w3-container" style="height: 52vh">
                <div class="w3-container" style="margin-top: 10%">
                    <font color="blue"> <h2><b>No Pending Cash Out Requests</b></h2></font>
                </div>
            </div>
        @else

        <div class="w3-panel">
            <div class="w3-row-padding w3-margin">

                <table class="w3-table w3-striped w3-hoverable w3-white">
                    <tr>
                        <th class="w3-center">Email</th>
                        <th class="w3-center">Method</th>
                        <th class="w3-center">Recipient Number</th>
                        <th class="w3-center">Amount</th>
                        <th class="w3-center">Action</th>
                    </tr>

                    @foreach($req as $r)
                        <tr>
                            <td class="w3-center">{{$r->email}}</td>
                            <td class="w3-center">{{$r->method}}</td>
                            <td class="w3-center">{{$r->recipient}}</td>
                            <td class="w3-center">{{$r->amount}}</td>

                            <td class="w3-center">
                                <form action="verifycashout" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$r->id}}">
                                    <input type="hidden" name="email" value="{{$r->email}}">
                                    <input type="hidden" name="date" value="{{$r->date}}">
                                    <input type="hidden" name="time" value="{{$r->time}}">
                                    <input type="hidden" name="description" value="{{$r->method}} cashout">
                                    <input type="hidden" name="amount" value="{{$r->amount}}">
                                    <button class="w3-button w3-black w3-hover-teal">Mark as Done</button>
                                </form>

                            </td>

                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
            @endif
    </center>
@endsection
@section('pagination')
    {{ $req->links() }}
    <hr>
    <hr>
@endsection
