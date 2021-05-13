@extends('layouts.dashlayout')


@section('title')
    <title>All Appointments</title>
@endsection


@section('header')
    <center><h5><b>All Appointments</b></h5></center>
@endsection

@section('content')

    @if(!$count)
        <div class="w3-container w3-center" style="height: 52vh">
            <div class="w3-container" style="margin-top: 10%">
                <font color="blue"> <h2><b>No Appointments Yet</b></h2></font>
            </div>
        </div>
    @else

    <div class="w3-panel" style="width: 40%">
        <form method="GET" action="/allappointments">
            @csrf

            <table class="w3-table w3-white">
                <tr>
                    <td>
                        <input type="text" name="app" class="w3-input" placeholder="Search by Appointment ID">
                    </td>

                    <td class="w3-center">
                        <button class="w3-button w3-black w3-hover-teal">Go</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
<hr>
    <center>
        <table class="w3-table w3-striped w3-hoverable w3-white">
           <tr>
               <th class="w3-center">Appointment ID</th>
               <th class="w3-center">Doctor</th>
               <th class="w3-center">Client</th>
               <th class="w3-center">Date</th>
               <th class="w3-center">Time</th>
               <th class="w3-center">Status</th>
           </tr>

            @foreach($data as $d)
                <tr>
                    <td class="w3-center">{{ucfirst($d->appointment)}}</td>
                    <td class="w3-center">{{$d->docmail}}</td>
                    <td class="w3-center">{{$d->clientmail}}</td>
                    <td class="w3-center">{{date('d-m-Y',strtotime($d->appointed_date))}}</td>
                    <td class="w3-center">
                        @if(strcmp((floatval($d->appointed_time)-intval($d->appointed_time)),'0.3')==0)
                            {{date('h:i A',strtotime(intval($d->appointed_time).'.30'))}}
                        @else
                            {{date('h:i A',strtotime($d->appointed_time.'.0'))}}<br>
                        @endif
                    </td>
                    <td class="w3-center">
                        @if(!$d->attended && !$d->unattended && !$d->cancelled)
                            <b><font color="blue">Pending</font> </b>
                        @elseif($d->attended)
                            <b><font color="green">Attended</font> </b>
                        @elseif($d->unattended)
                            <b><font color="red">Unattended</font> </b>
                        @elseif($d->cancelled)
                            <b><font color="red">Cancelled</font> </b>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </center>
    @endif
@endsection

@section('pagination')
    {{ $data->links() }}
    <hr>
    <hr>
@endsection
