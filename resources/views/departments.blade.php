@extends('layouts.dashlayout')


@section('title')
    <title>Departments</title>
@endsection


@section('header')
    <center>
    <h5><b>Departments</b></h5>
    </center>
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
                <div class="w3-row-padding" style="width: 70%">
                    <h5 align="left"><b>Add New Department</b></h5>
                    <form method="post" action="dptadd">
                        @csrf
                        <table class="w3-table  w3-white">
                            <tr>
                                <td class="w3-padding-16">
                                    <input class="w3-input w3-border" type="text" name="dptcode" placeholder="Department Code" required>
                                </td>
                            </tr>

                            <tr>
                                <td class="w3-padding-16">
                                    <input class="w3-input w3-border" type="text" name="dptname" placeholder="Department Name" required>
                                    <input type="hidden" name="count" value='0'>
                                </td>
                            </tr>

                            <tr>
                                <td class="w3-padding-16 w3-right">
                                    <button class="w3-button w3-black w3-hover-teal">Add Department</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <hr><hr>

                @if(!$count)
                    <div class="w3-container" style="height: 21vh">
                        <div class="w3-container">
                            <font color="blue"> <h2><b>No Department Added</b></h2></font>
                        </div>
                    </div>
                @else

                <div class="w3-row-padding w3-margin" style="width: 70%">
                    <table class="w3-table w3-striped w3-hoverable w3-white">


                        <tr>
                            <th class="w3-center">Department Code</th>
                            <th class="w3-center">Department Name</th>
                            <th class="w3-center">Assigned Doctors</th>
                            <th class="w3-center">Delete</th>
                        </tr>
                        @foreach($departments as $dpt)
                            <tr>
                            <td class="w3-center">{{$dpt->dptcode}}</td>
                            <td class="w3-center">{{$dpt->dptname}}</td>
                            <td class="w3-center">{{$dpt->total_doc}}</td>


                            <td class="w3-center">
                            <form action="/dptdel/{{$dpt->id}}" method="post">
                                @csrf
                                <button class="w3-button w3-black w3-hover-teal">Delete</button>
                            </form>
                            </td>
                            </tr>

                        @endforeach

                    </table>
                </div>
                @endif
@endsection

@section('pagination')
    {{ $departments->links() }}
    <hr>
    <hr>
@endsection
