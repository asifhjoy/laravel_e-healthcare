@extends('layouts.dashlayout')


@section('title')
    <title>Dashboard</title>
@endsection



@section('header')
    <h5><b>Client Dashboard</b></h5>
@endsection

@section('content')
    <center>

        <div class="w3-panel w3-hover-shadow" style="width: 50%">
            <ul class="w3-ul">
                <li class="w3-padding-16 w3-large">Congratulations!</li>
                <li class="w3-padding-16 w3-large">You have been successfully Registered as one of our precious client.</li>
                <li class="w3-padding-16 w3-large"> As a token of Gratitude we offer you a 100 TK credit to your Account.</li>
                <li class="w3-padding-16 w3-large">
                    <form action="newclient" method="POST">
                        @csrf
                        <button class="w3-button w3-black w3-hover-teal">Claim Now!</button>
                    </form> </li>
            </ul>
        </div>

    </center>
@endsection

