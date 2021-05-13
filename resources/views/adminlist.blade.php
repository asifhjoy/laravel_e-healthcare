@extends('layouts.dashlayout')


@section('title')
    <title>Admin List</title>
@endsection


@section('header')
    <center><h5><b>Admin List</b></h5></center>
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



        <div class="w3-panel">

            <div class="w3-row-padding w3-margin" style="width: 70%">
                <h5 align="left"><b>Add New Admin</b></h5>
                <form method="post" action="sendlink">
                    @csrf
                <table class="w3-table w3-striped w3-hoverable w3-white">
                   <tr>
                    <td class="w3-padding-16">
                        <input class="w3-input w3-border" type="email" name="email" placeholder="Email">
                    </td>
                    <td> </td>
                       <td class="w3-padding-16"> <button class="w3-button w3-black w3-hover-teal">Send Registration Link</button></td>
                    </tr>
                </table>
                </form>
            </div>

            <hr><hr>
            @if(!$count)
                <div class="w3-container" style="height: 30vh">
                    <div class="w3-container" style="margin-top: 5%">
                        <font color="blue"> <h2><b>No Admin Added Yet</b></h2></font>
                    </div>
                </div>
            @else

            <div class="w3-row-padding w3-margin" style="width: 70%">


                <table class="w3-table w3-striped w3-hoverable w3-white">
                    <tr>
                        <th class="w3-center">Profile Picture</th>
                        <th class="w3-center">Name</th>
                        <th class="w3-center">Email</th>
                        <th class="w3-center">Phone</th>
                        <th class="w3-center">Age</th>
                        <th class="w3-center">Gender</th>
                    </tr>

                    @foreach($admins as $user)
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
                            <td class="w3-center"> {{\Carbon\Carbon::parse($user->bday)->diff(\Carbon\Carbon::now())->y}}</td>
                            <td class="w3-center">{{$user->gender}}</td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
                @endif
    </center>
@endsection

@section('pagination')
    {{ $admins->links() }}
    <hr>
    <hr>
@endsection


