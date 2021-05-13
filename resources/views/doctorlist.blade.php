@extends('layouts.dashlayout')


@section('title')
    <title>Doctor List</title>
@endsection


@section('header')
    <center><h5><b>Doctor List</b></h5></center>
@endsection

@section('content')

    @if(!$count)
        <div class="w3-container w3-center" style="height: 52vh">
            <div class="w3-container" style="margin-top: 10%">
                <font color="blue"> <h2><b>No Doctor Registered Yet</b></h2></font>
            </div>
        </div>
    @else

    <div class="w3-panel" style="width: 40%; padding-left: 50px">
        <form method="GET" action="/doctorlist">
            @csrf
            <table class="w3-table w3-white">
                <tr>
                    <td>
                        <input type="text" name="email" class="w3-input" placeholder="Search with Email">
                    </td>

                    <td class="w3-center">
                        <button class="w3-button w3-black w3-hover-teal">Go</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <hr><hr>
    <center>

        <div class="w3-panel">
            <div class="w3-row-padding w3-margin">


                <table class="w3-table w3-striped w3-hoverable w3-white">
                    <tr>
                        <th class="w3-center">Profile Picture</th>
                        <th class="w3-center">Name</th>
                        <th class="w3-center">Email</th>
                        <th class="w3-center">Phone</th>
                        <th class="w3-center">Age</th>
                        <th class="w3-center">Gender</th>
                        <th class="w3-center">Department</th>
                        <th class="w3-center">Visiting Hours</th>
                        <th class="w3-center">Charge</th>
                        <th class="w3-center">Visiting Days</th>
                    </tr>

                    @foreach($doctors as $user)
                        <tr>
                            <td class="w3-center">
                                @if($user->pic)
                                    <img src="{{asset('/storage/userimages/'.$user->pic)}}" alt="{{$user->name}}" class="w3-circle w3-margin-right" style="width:50px">
                                @else
                                    @if($user->gender=='Male')
                                        <img src="/img/defaults/male.jpg" class="w3-circle w3-margin-right" style="width:50px">
                                    @elseif($user->gender=='Female')
                                        <img src="/img/defaults/female.jpg" class="w3-circle w3-margin-right" style="width:50px">
                                    @else
                                        <img src="/img/defaults/others.png" class="w3-circle w3-margin-right" style="width:50px">
                                    @endif
                                @endif
                            </td>
                            <td class="w3-center">{{$user->name}}</td>
                            <td class="w3-center">{{$user->email}}</td>
                            <td class="w3-center">{{$user->phone}}</td>
                            <td class="w3-center">{{\Carbon\Carbon::parse($user->bday)->diff(\Carbon\Carbon::now())->y}}</td>
                            <td class="w3-center">{{$user->gender}}</td>
                            <td class="w3-center">{{$user->dptname}}</td>
                            <td class="w3-center">{{date("h:i A", strtotime($user->stime))}} to {{date("h:i A", strtotime($user->ftime))}}</td>
                            <td class="w3-center">৳ {{$user->rate}}</td>
                            <td class="w3-center">
                                @if($user->sat)
                                    Saturday<br>
                                @endif

                                @if($user->sun)
                                    Sunday<br>
                                @endif

                                @if($user->mon)
                                    Monday<br>
                                @endif

                                @if($user->tues)
                                    Tuesday<br>
                                @endif

                                @if($user->wed)
                                    Wednesday<br>
                                @endif

                                @if($user->thurs)
                                    Thursday<br>
                                @endif

                                @if($user->fri)
                                    Friday<br>
                                @endif</td>

                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </center>
    @endif
@endsection

@section('pagination')
    {{ $doctors->links() }}
    <hr>
    <hr>
@endsection
