
<style>


    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 300px; /* Location of the box */
        left: 0;
        top: 0;
        width: 110%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


@extends('layouts.dashlayout')


@section('title')
    <title>Details</title>
@endsection




@section('content')
    <center>
@php($appdate='')
@php($appid='')
 @php($flag='')
 @php($stat='')
@if($data)
@foreach($data as $data)
    @php($appid=$data->appointment)

                <div class="w3-row-padding w3-margin" style="width: 100%">

                        @if($data->pic)
                            <img src="{{asset('/storage/dataimages/'.$data->pic)}}" alt="{{$data->name}}" class=" w3-margin-right" style="width:200px; margin-top: 30px">
                        @else
                            @if($data->gender=='Male')
                                <img src="/img/defaults/male.jpg" class="w3-margin-right" style="width:200px; margin-top: 30px">
                            @elseif($data->gender=='Female')
                                <img src="/img/defaults/female.jpg" class="w3-margin-right" style="width:200px; margin-top: 30px">
                            @else
                                <img src="/img/defaults/others.png" class=" w3-margin-right" style="width:200px; margin-top: 30px">
                            @endif
                        @endif

                        <hr>
                        <b>{{$data->name}}</b> <br>
                        <b>{{$data->email}}</b>


                </div>
                <hr>
                    <table class="w3-table w3-white" style="width: 60%">

                        <tr>
                            <th>Phone</th>
                            <td>:</td>
                            <td>{{$data->phone}}</td>
                        </tr>

                        <tr>
                            <th>Age</th>
                            <td>:</td>
                            <td>{{\Carbon\Carbon::parse($data->bday)->diff(\Carbon\Carbon::now())->y}}</td>
                        </tr>

                        <tr>
                            <th>Gender</th>
                            <td>:</td>
                            <td>{{$data->gender}}</td>
                        </tr>

                        @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                        <tr>
                            <th>Department</th>
                            <td>:</td>
                            <td>{{$data->dptname}}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Appointment Time</th>
                            <td>:</td>
                            <td> @if(strcmp((floatval($data->appointed_time)-intval($data->appointed_time)),'0.3')==0)
                                    {{date('h:i A',strtotime(intval($data->appointed_time).'.30'))}}
                                @else
                                    {{date('h:i A',strtotime($data->appointed_time.'.0'))}}<br>
                                @endif</td>
                        </tr>

                        <tr>
                            <th>Appointment Date</th>
                            <td>:</td>
                            <td>
                                {{date('d-m-Y',strtotime($data->appointed_date))}}
                                @php($appdate=$data->appointed_date)
                            </td>
                        </tr>
                        <tr>
                            <th>Appointment Charge</th>
                            <td>:</td>
                            <td>৳ {{$data->rate}} (Paid in Advance)</td>
                        </tr>
                        <tr>
                            <th>Appointment Status</th>
                            <td>:</td>
                            <td>
                                @if(!$data->attended && !$data->unattended && !$data->cancelled)
                                    <b><font color="blue">Pending</font> </b>
                                    @php($stat='Pending')
                                @elseif($data->attended)
                                    <b><font color="green">Attended</font> </b>
                                @elseif($data->unattended)
                                    <b><font color="red">Unattended</font> </b>
                                @elseif($data->cancelled)
                                    <b><font color="red">Cancelled</font> </b>
                                @endif

                            </td>
                        </tr>
                        @if(date(strtotime($data->appointed_date))==strtotime(\Carbon\Carbon::today()) && !$data->attended && !$data->unattended && !$data->cancelled)
                        <tr>
                            <th>Meeting Link</th>
                            <td>:</td>
                            <td>
                                <a href="{{$data->link}}" target="_blank">{{$data->link}}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Meeting Room</th>
                            <td>:</td>
                            <td>{{$data->code}}</td>
                        </tr>
                        <tr>
                            <th>Meeting Room Password</th>
                            <td>:</td>
                            <td>{{$data->pw}}</td>
                        </tr>
                        @endif
                        <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                        </tr>

                        @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                        @if(!$data->attended && !$data->unattended)
                            <tr>
                            @if($data->cancelled)
                                </tr>
                            @else
                                <td class="w3-center">
                                    @if(date(strtotime($data->appointed_date))==strtotime(\Carbon\Carbon::today()))
                                        <button class="w3-black w3-button w3-hover-teal" disabled>Reschedule Appointment</button><br>
                                        <b><font color="red">You cannot Reschedule <br>on due date </font> </b>
                                    @else
                                    <a href="/appointment/{{$data->docmail}}/{{$data->appointment}}/reschedule">
                                            <button class="w3-black w3-button w3-hover-teal" >Reschedule Appointment</button>
                                        </a>
                                    @endif
                                </td>

                                <td></td>

                                <td class="w3-center">
                                        <button class="w3-black w3-button w3-hover-teal" id="myBtn" >Cancel Appointment</button>
                                </td>
                                </tr>
                            @endif
                        @endif
                        @elseif(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                            @if($stat=='Pending')
                            <td class="w3-center" colspan="3">
                                @php($balance = \App\Balance::where('email',\Illuminate\Support\Facades\Auth::user()->email)->value('balance'))
                                @if($balance>=($data->rate+$data->rate*0.2)+50)
                                    <button class="w3-black w3-button w3-hover-teal" id="myBtn">Cancel Appointment</button>
                                @else
                                    <font color="red"><b>You can not cancel this Appointment. Refund Fees exceeds your current balance. Top Up and Try Again.</b></font><hr>
                                    <button class="w3-black w3-button w3-hover-teal" id="myBtn" disabled>Cancel Appointment</button>
                                @endif

                            </td>
                            @endif
                            </tr>
                         @endif
                    </table>

        @endforeach
    @endif

    </center>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" >
            <table class="w3-table w3-white">
                <tr>
                    <td>
                        <span class="close">&times;</span>
                    </td>
                </tr>

                <tr>
                    @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client')
                    <td class="w3-center">
                        @if(date(strtotime($appdate))==strtotime(\Carbon\Carbon::today()))
                        <font color="red"><b>You will not get any REFUND if you Cancel your Appointment Today</b></font>
                            @php($flag=1)
                        @else
                            <font color="red"><b>You will get only 50% REFUND if you Cancel your Appointment Today</b></font>
                            @php($flag=0)
                        @endif
                    </td>
                @elseif(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                        <td class="w3-center">
                            <font color="red"><b>(Visiting Rate + 20%) = ৳{{$data->rate+$data->rate*0.2}}  will be deducted from your account if you cancel this Appointment</b></font>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="w3-center"><hr>
                        <form action="/appointment/cancel" method="POST">
                            @csrf
                            <input type="hidden" name="appid" value="{{$appid}}">
                            <input type="hidden" name="flag" value="{{$flag}}">
                        <button class="w3-button w3-black w3-hover-red">I Understand</button>
                        </form>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>



@endsection

