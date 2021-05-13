@extends('layouts.dashlayout')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

@section('title')


    <title>
        @if($reschedule)
            Reschedule Appointment
        @else
            Make Appointment
        @endif
    </title>
@endsection


@section('header')
    <center><h5><b>
                @if($reschedule)
                    Reschedule Appointment
                @else
                    New Appointment
                @endif
            </b></h5></center>
@endsection



@section('content')
    <center>
@php($days=[])
@php($dates=[])
@php($amount='')
@php($stat='')
@php($clientamount=\App\Balance::where('email',\Illuminate\Support\Facades\Auth::user()->email)->value('balance'))




    @foreach($doctor as $user)

        <div class="w3-panel" style="width: 70%">
            <div class="w3-row-padding w3-margin" style="width: 100%">

                <div class="w3-half">

                                @if($user->pic)
                                    <img src="{{asset('/storage/userimages/'.$user->pic)}}" alt="{{$user->name}}" class=" w3-margin-right" style="width:200px">
                                @else
                                    @if($user->gender=='Male')
                                        <img src="/img/defaults/male.jpg" class="w3-margin-right" style="width:200px">
                                    @elseif($user->gender=='Female')
                                        <img src="/img/defaults/female.jpg" class="w3-margin-right" style="width:200px">
                                    @else
                                        <img src="/img/defaults/others.png" class=" w3-margin-right" style="width:200px">
                                    @endif
                                @endif

                               <br><br>
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
                        <th>Visiting Charge</th>
                        <td>:</td>
                        <td>৳ {{$user->rate}}
                            @php($docamount=$user->rate)
                        </td>
                    </tr>

                    <tr>
                        <th>Visiting Days</th>
                        <td>:</td>
                        <td>
                            @if($user->sat)
                                    @php($days[]='Saturday')
                                Saturday<br>
                            @endif

                            @if($user->sun)
                                    @php($days[]='Sunday')
                                Sunday<br>
                            @endif

                            @if($user->mon)
                                    @php($days[]='Monday')
                                Monday<br>
                            @endif

                            @if($user->tues)
                                    @php($days[]='Tuesday')
                                Tuesday<br>
                            @endif

                            @if($user->wed)
                                    @php($days[]='Wednesday')
                                Wednesday<br>
                            @endif

                            @if($user->thurs)
                                    @php($days[]='Thursday')
                                Thursday<br>
                            @endif

                            @if($user->fri)
                                    @php($days[]='Friday')
                                Friday<br>
                            @endif
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    @endforeach



@php($x=0)
        <div class="w3-container w3-panel" style="width:80%">
            <center><h5><b>Select Appointment Date and Time</b></h5></center>
             @if($reschedule)
                <form action="/confirmreschedule" method="POST">
             @else
                <form action="/confirmappointment" method="POST">
             @endif
                @csrf

            <table class="w3-table w3-white w3-striped" id="chk">

                @foreach($doctor as $d)
                <input type="hidden" name="docmail" value="{{$d->email}}">
                <input type="hidden" name="amount" value="{{$d->rate}}">
                    <tr>
                        <th class="w3-center">Time/Date</th>
                        @for($i=1;$i<15;$i++)
                         @php($cday = date('l', strtotime(\Carbon\Carbon::today()->addDay($i))))
                          @for($j=0;$j<count($days);$j++)
                           @if($cday==$days[$j])
                                    <th class="w3-center">{{date('d-m-Y  (l)',strtotime(\Carbon\Carbon::today()->addDay($i)))}}
                                        @php($dates[]=date('Y-m-d',strtotime(\Carbon\Carbon::today()->addDay($i))))
                                        @php($x++)
                                    </th>
                            @endif
                           @endfor
                        @endfor
                    </tr>

                    @for($i=intval($d->stime);$i<intval($d->ftime);)
                        @for($k=1;$k<=4;$k++)
                            <tr>
                                <th class="w3-center">
                            @if($k%3==0)
                                {{ date('h:i A',strtotime(intval($i).'.30'))}}
                            @else
                                        {{date('h:i A',strtotime($i.'.0'))}}
                            @endif
                                </th>


                                @for($t=1;$t<=$x;$t++)
                                    @php($stat=0)
                                    <td class="w3-center">
                                        @foreach($dt as $us)
                                            @if($dates[$t-1]==$us->appointed_date && (strcmp($i,$us->appointed_time))==0)
                                                @if(strcmp($us->clientmail,\Illuminate\Support\Facades\Auth::user()->email)==0)
                                                   <font color="blue">My Appointment</font>
                                                    @php($stat=1)
                                                @else
                                                    <font color="red">Booked</font>
                                                    @php($stat=1)
                                                @endif
                                            @endif
                                        @endforeach
                                            @if($stat==0)
                                            <input type="checkbox"  name="datetime" value="{{$dates[$t-1]}},{{$i}}">
                                            @endif
                                    </td>
                                @endfor


                            </tr>
                            @php($i=$i+0.15)
                        @endfor
                            @php($i=intval($i)+1)
                    @endfor
                @endforeach
            </table>

            <hr>


            @if($reschedule)
                 <div class="w3-container w3-panel w3-center" style="width: 70%">
                   <center><h5><b>Terms and Conditions</b></h5></center>
                    <table class="w3-table w3-white">
                        <tr>
                            <td class="w3-center">At least ৳ 50 should be in your account all the time after Transaction<br><br>
                                <font color="red"> <b> ৳ {{$docamount*0.2}} will be charged for Rescheduling</b></font></td>
                        </tr>
                        <tr>
                            <td class="w3-center">
                                <input type="hidden" name="appid" value="{{$appointment}}">
                                @if($clientamount>$docamount*0.2+50)
                                    <button class="w3-button w3-black w3-hover-teal" id="btnchk">Confirm Reschedule</button>
                                @else
                                    <font color="red"> <b>Not Enough Credit</b></font><br><br>
                                    <button class="w3-button w3-black w3-hover-teal" id="btnchk" disabled>Confirm Reschedule</button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                </form>
            @else
                <div class="w3-container w3-panel w3-center" style="width: 70%">
                    <center><h5><b>Terms and Conditions</b></h5></center>
                    <table class="w3-table w3-white">
                        <tr>
                            <td>1. Check holidays before selecting the visiting day.</td>
                        </tr>
                        <tr>
                            <td>2. Visiting Charge will be paid in Advance from your account upon Confirming Appointment.</td>
                        </tr>
                        <tr>
                            <td>3. 10% extra + original credit will be added to your account if Doctor cancels any Appointment.</td>
                        </tr>
                        <tr>
                            <td>4. Only 50% credit is refundable if you cancel any appointment before the due date.</td>
                        </tr>
                        <tr>
                            <td>5. No credit refund is possible if you cancel any appointment on the due date.</td>
                        </tr>
                        <tr>
                            <td>6. At least ৳ 50 should be in your account all the time.</td>
                        </tr>
                        <tr>
                            <td>7. Rescheduling is only possible before due date.</td>
                        </tr>
                        @if($clientamount<$docamount+50)
                            <tr>
                                <td class="w3-center"><br><b><font color="red"> You are not eligible to make appointment with this Doctor as your credit is low.</font></b></td>
                            </tr>
                        @endif

                        <tr>

                            <input type="hidden" name="clientmail" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                            <td class="w3-center"><hr>

                                @if($clientamount<$docamount+50)
                                    <button class="w3-button w3-black w3-hover-teal" id="btnchk" disabled>Confirm Appointment</button>
                                @else
                                    <button class="w3-button w3-black w3-hover-teal" id="btnchk">Confirm Appointment</button>
                                @endif
                                </td>
                        </tr>
                    </table>
                </div>

            </form>
        </form>
        @endif
       <hr>



    </center>
    <script type="text/javascript">
        $(function () {
            $("#btnchk").click(function () {
                //Reference the CheckBoxes and determine Total Count of checked CheckBoxes.
                var checked = $("#chk input[type=checkbox]:checked").length;

                if (checked != 1) {
                    if(checked>1)
                    {
                        alert('Please select ONLY ONE Date and Time !!!');
                        return false;
                    }
                    else {
                        alert('Please select a Date and Time !!!');
                        return false;
                    }

                }
                else
                {
                    return true;
                }
            });
        });
    </script>
@endsection
