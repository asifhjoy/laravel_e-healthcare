@extends('layouts.dashlayout')


@section('title')
    <title>Doctor Requests</title>
@endsection


@section('header')
    <center><h5><b>Doctor Requests</b></h5></center>
@endsection



@section('content')
    <center>
        @if(!$count)
            <div class="w3-container" style="height: 52vh">
            <div class="w3-container" style="margin-top: 10%">
               <font color="blue"> <h2><b>No Pending Doctor Requests</b></h2></font>
            </div>
            </div>
        @else
    @foreach($data as $user)

        <div class="w3-panel" style="width: 70%">
            <div class="w3-row-padding w3-margin" style="width: 100%">

                <div class="w3-half">



                                @if($user->pic)
                                    <img src="{{asset('/storage/userimages/'.$user->pic)}}" alt="{{$user->name}}" class=" w3-margin-right" style="width:200px; margin-top: 30px">
                                @else
                                    @if($user->gender=='Male')
                                        <img src="/img/defaults/male.jpg" class="w3-margin-right" style="width:200px; margin-top: 30px">
                                    @elseif($user->gender=='Female')
                                        <img src="/img/defaults/female.jpg" class="w3-margin-right" style="width:200px; margin-top: 30px">
                                    @else
                                        <img src="/img/defaults/others.png" class=" w3-margin-right" style="width:200px; margin-top: 30px">
                                    @endif
                                @endif

                                <hr>
                                <b>{{$user->name}}</b> <br>
                                <b>{{$user->email}}</b>


                </div>
                <table class="w3-table w3-white w3-half">

                    <tr>
                            <th>Phone</th>
                            <td>:</td>
                            <td>{{$user->phone}}</td>
                    </tr>

                    <tr>
                        <th>Age</th>
                        <td>:</td>
                         <td>{{\Carbon\Carbon::parse($user->bday)->diff(\Carbon\Carbon::now())->y}}</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>:</td>
                        <td>{{$user->gender}}</td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <td>:</td>
                        <td>{{$user->dptname}}</td>
                    </tr>

                    <tr>
                        <th>Visiting Hour</th>
                        <td>:</td>
                        <td>{{date("h:i A", strtotime($user->stime))}} to {{date("h:i A", strtotime($user->ftime))}}</td>
                    </tr>

                    <tr>
                        <th>Visiting Days</th>
                        <td>:</td>
                        <td>
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
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Visiting Charge</th>
                        <td>:</td>
                        <td>৳ {{$user->rate}}</td>
                    </tr>
                    <tr>
                        <th>CV</th>
                        <td>:</td>
                        <td> <a href="{{asset('storage/cv/'.$user->cv)}}">Download</a><br></td>
                    </tr>

                    <tr>
                        <td>
                            <form action="/requests/accept" method="post">
                                @csrf
                                <input type="hidden" name="email" value="{{$user->email}}">
                                <button class="w3-button w3-left w3-black w3-hover-teal">Accept</button>
                            </form>
                        </td>
                        <td></td>
                        <td>
                            <form action="/requests/reject" method="post">
                                @csrf
                                <input type="hidden" name="email" value="{{$user->email}}">
                                <button class="w3-button w3-right w3-black w3-hover-teal">Reject</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


    @endforeach
@endif
    </center>
@endsection

@section('pagination')
    {{ $data->links() }}
    <hr>
    <hr>
@endsection
