@extends('layouts.dashlayout')


@section('title')
    <title>Appointments</title>
@endsection


@section('header')
    <center><h5><b>Appointments Report</b></h5></center>
@endsection

@section('content')
    @php($time='')
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

            @if($pending)
        <div class="w3-panel">
            <div class="w3-row-padding w3-margin">

                <h5 align="left"><b>Pending Appointments</b></h5>
                <table class="w3-table w3-striped w3-hoverable w3-white">
                    <tr>
                        <th class="w3-center">Appointment ID</th>
                        <th class="w3-center">
                            @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                                Doctor Name
                            @elseif(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                                Client Name
                            @endif
                        </th>
                        <th class="w3-center">Phone</th>
                        <th class="w3-center">Date</th>
                        <th class="w3-center">Time</th>
                        @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                        <th class="w3-center">Join</th>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                        <th class="w3-center">Status Update</th>
                        @endif
                        <th class="w3-center">Details</th>

                    </tr>



                    @foreach($pending as $d)
                        <tr>
                            <td class="w3-center">{{ucfirst($d->appointment)}}</td>
                            <td class="w3-center">{{$d->name}}</td>
                            <td class="w3-center">{{$d->phone}}</td>
                            <td class="w3-center">{{date('d-m-Y',strtotime($d->appointed_date))}}</td>
                            <td class="w3-center">
                                @if(strcmp((floatval($d->appointed_time)-intval($d->appointed_time)),'0.3')==0)
                                    {{date('h:i A',strtotime(intval($d->appointed_time).'.30'))}}

                                @else
                                    {{date('h:i A',strtotime($d->appointed_time.'.0'))}}
                                @endif

                            </td>



                            @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                                <td class="w3-center">

                                @if(date('d-m-Y',strtotime(\Carbon\Carbon::now()))==date('d-m-Y',strtotime($d->appointed_date)))
                                    <a href='{{$d->link}}' target="_blank"><button class="w3-button w3-black w3-hover-teal">Join Now</button></a>
                                @elseif(date('d-m-Y',strtotime(\Carbon\Carbon::now()))<date('d-m-Y',strtotime($d->appointed_date)))
                                    <a href='{{$d->link}}' target="_blank"><button class="w3-button w3-black w3-hover-teal" disabled>Join Now</button></a>
                                @endif
                                </td>
                             @endif


                            @if(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                            <td class="w3-center">
                                <a href="/flagattended/{{$d->appointment}}">
                                    <button class="w3-button w3-black w3-hover-teal" >Flag as Attended</button>
                                </a>
                            </td>
                            @endif
                            <td class="w3-center">
                                <a href="/appointment/details/{{$d->appointment}}" target="_blank"><button class="w3-button w3-black w3-hover-teal">Details</button></a>
                            </td>


                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
            @endif
        <hr>


            @if($unattended)
        <div class="w3-panel">
            <div class="w3-row-padding w3-margin">

                <h5 align="left"><b>Unattended Appointments</b></h5>
                <table class="w3-table w3-striped w3-hoverable w3-white">
                    <tr>
                        <th class="w3-center">Appointment ID</th>
                        <th class="w3-center">
                            @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                                Doctor Name
                            @elseif(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                                Client Name
                            @endif
                        </th>
                        <th class="w3-center">Phone</th>
                        <th class="w3-center">Date</th>
                        <th class="w3-center">Time</th>
                        <th class="w3-center">Details</th>

                    </tr>


                    @foreach($unattended as $d)
                        <tr>
                            <td class="w3-center">{{ucfirst($d->appointment)}}</td>
                            <td class="w3-center">{{$d->name}}</td>
                            <td class="w3-center">{{$d->phone}}</td>
                            <td class="w3-center">{{date('d-m-Y',strtotime($d->appointed_date))}}</td>
                            <td class="w3-center">
                                @if(strcmp((floatval($d->appointed_time)-intval($d->appointed_time)),'0.3')==0)
                                    {{date('h:i A',strtotime(intval($d->appointed_time).'.30'))}}
                                @else
                                    {{date('h:i A',strtotime($d->appointed_time.'.0'))}}<br>
                                @endif
                            </td>

                            <td class="w3-center">
                                <a href="/appointment/details/{{$d->appointment}}" target="_blank"><button class="w3-button w3-black w3-hover-teal">Details</button></a>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
            @endif
        <hr>


            @if($cancelled)
        <div class="w3-panel">
            <div class="w3-row-padding w3-margin">

                <h5 align="left"><b>Cancelled Appointments</b></h5>
                <table class="w3-table w3-striped w3-hoverable w3-white">
                    <tr>
                        <th class="w3-center">Appointment ID</th>
                        <th class="w3-center">
                            @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                                Doctor Name
                            @elseif(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                                Client Name
                            @endif
                        </th>
                        <th class="w3-center">Phone</th>
                        <th class="w3-center">Date</th>
                        <th class="w3-center">Time</th>
                        <th class="w3-center">Details</th>

                    </tr>


                    @foreach($cancelled as $d)
                        <tr>
                            <td class="w3-center">{{ucfirst($d->appointment)}}</td>
                            <td class="w3-center">{{$d->name}}</td>
                            <td class="w3-center">{{$d->phone}}</td>
                            <td class="w3-center">{{date('d-m-Y',strtotime($d->appointed_date))}}</td>
                            <td class="w3-center">
                                @if(strcmp((floatval($d->appointed_time)-intval($d->appointed_time)),'0.3')==0)
                                    {{date('h:i A',strtotime(intval($d->appointed_time).'.30'))}}
                                @else
                                    {{date('h:i A',strtotime($d->appointed_time.'.0'))}}<br>
                                @endif

                            </td>
                            <td class="w3-center">
                                <a href="/appointment/details/{{$d->appointment}}" target="_blank"><button class="w3-button w3-black w3-hover-teal">Details</button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

                @if($completed)
                    <div class="w3-panel">
                        <div class="w3-row-padding w3-margin">

                            <h5 align="left"><b>Attended Appointments</b></h5>
                            <table class="w3-table w3-striped w3-hoverable w3-white">
                                <tr>
                                    <th class="w3-center">Appointment ID</th>
                                    <th class="w3-center">
                                        @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                                            Doctor Name
                                        @elseif(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                                            Client Name
                                        @endif
                                    </th>
                                    <th class="w3-center">Phone</th>
                                    <th class="w3-center">Date</th>
                                    <th class="w3-center">Time</th>
                                    <th class="w3-center">Details</th>

                                </tr>


                                @foreach($completed as $d)
                                    <tr>
                                        <td class="w3-center">{{ucfirst($d->appointment)}}</td>
                                        <td class="w3-center">{{$d->name}}</td>
                                        <td class="w3-center">{{$d->phone}}</td>
                                        <td class="w3-center">{{date('d-m-Y',strtotime($d->appointed_date))}}</td>
                                        <td class="w3-center">
                                            @if(strcmp((floatval($d->appointed_time)-intval($d->appointed_time)),'0.3')==0)
                                                {{date('h:i A',strtotime(intval($d->appointed_time).'.30'))}}
                                            @else
                                                {{date('h:i A',strtotime($d->appointed_time.'.0'))}}<br>
                                            @endif

                                        </td>


                                        <td class="w3-center">
                                            <a href="/appointment/details/{{$d->appointment}}" target="_blank"><button class="w3-button w3-black w3-hover-teal">Details</button></a>
                                        </td>

                                    </tr>
                                @endforeach




                            </table>
                        </div>
                    </div>
                @endif
                <hr>
            @endif

    </center>
@endsection


