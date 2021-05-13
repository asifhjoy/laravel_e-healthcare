@extends('layouts.dashlayout')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')

        @include('clock')


    <div class="container">

    <div class='w3-container' style="padding-left: 100px">

        <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
            <table class="w3-table">
                <tr>
                    <th colspan="3" class="w3-center w3-black">Appointments Statistics</th>
                </tr>
                <tr>
                    <th>
                        Ongoing Appointments
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Appointment::where([['attended','0'],['unattended','0'],['cancelled','0']])->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Attended Appointments
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Appointment::where([['attended','1'],['unattended','0'],['cancelled','0']])->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Unattended Appointments
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Appointment::where([['attended','0'],['unattended','1'],['cancelled','0']])->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Cancelled Appointments
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Appointment::where([['attended','0'],['unattended','0'],['cancelled','1']])->count()}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
            <table class="w3-table">
                <tr>
                    <th colspan="3" class="w3-center w3-black">Requests Statistics</th>
                </tr>
                <tr>
                    <th>
                        Top up Requests
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\TopUp::where('verified','0')->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Cashout Requests
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Cashout::where('verified','0')->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Doctor Activation Requests
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Doctor::where([['requested','1'],['active','0']])->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Other  Requests
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        0
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <br>

    <div class='w3-container' style="padding-left: 100px">

        <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
            <table class="w3-table">
                <tr>
                    <th colspan="3" class="w3-center w3-black">User Statistics</th>
                </tr>
                <tr>
                    <th>
                        Number of Admins
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\User::where('utype','Admin')->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Number of Clients
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\User::where('utype','Client')->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Number of Doctors (Active/Total)
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Doctor::where('active','1')->count()}} / {{\App\User::where('utype','Doctor')->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Associated Departments
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Departments::all()->count()}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="w3-container w3-half w3-border w3-hover-border-black w3-hover-shadow w3-margin" style="width: 45%">
            <table class="w3-table">
                <tr>
                    <th colspan="3" class="w3-center w3-black">Transaction Statistics</th>
                </tr>
                <tr>
                    <th>
                        Today's Transactions
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Transaction::where('date',\Carbon\Carbon::today())->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Total Transactions
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Transaction::all()->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                       Total Debit Transactions
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Transaction::where('type','Debit')->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                       Total Credit Transactions
                    </th>
                    <td>
                        :
                    </td>
                    <td>
                        {{\App\Transaction::where('type','Credit')->count()}}
                    </td>
                </tr>
            </table>
        </div>
    </div>


</div>


@endsection
