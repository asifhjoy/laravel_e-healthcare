@extends('layouts.dashlayout')

<style>
    /* Style the button that is used to open and close the collapsible content */
    .collapsible {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    .active, .collapsible:hover {
        background-color: #ccc;
    }

    /* Style the collapsible content. Note: hidden by default */
    .content {
        padding: 0 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
    }
    .view input {
        border:0;
        background:0;
        outline:none !important;
    }
    #clickableAwesomeFont {
        cursor: pointer
    }
</style>

@section('title')
    <title>Profile</title>
@endsection


@section('header')
    <center>
    <h5><b>My Profile</b></h5>
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
    </center>
@endsection

@section('content')
<center>

    <div class="w3-container">
        <div class="w3-half">
            <hr>
        @if(Auth::user()->pic)
            <img src="{{asset('/storage/userimages/'.Auth::user()->pic)}}" alt="{{\Illuminate\Support\Facades\Auth::user()->name}}" width="200" height="220">
        @else
            @if(Auth::user()->gender=='Male')
                <img src="/img/defaults/male.jpg" alt="{{\Illuminate\Support\Facades\Auth::user()->name}}" width="200" height="220">
            @elseif(Auth::user()->gender=='Female')
                <img src="/img/defaults/female.jpg" alt="{{\Illuminate\Support\Facades\Auth::user()->name}}" width="200" height="220">
            @else
                <img src="/img/defaults/others.png" alt="{{\Illuminate\Support\Facades\Auth::user()->name}}" width="200" height="220">
            @endif
        @endif
            <hr>
                <form action="dpupload" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="pic" accept="image/*" id="filetype" onchange="validateFileType()" required>
                    <button class="w3-button w3-black w3-hover-teal">Change Profile Picture</button>
                </form>
                <hr>


                @if(Auth::user()->pic)
                    <form action="dpdel" method="post">
                        @csrf
                        <button class="w3-button w3-center w3-black w3-hover-teal">Remove Profile Picture</button>
                    </form>
                @endif
    </div>


    <div class="w3-half">
        <div class="w3-row-padding">
            <h5><b>General Information</b></h5>
            <form action="/savechanges" method="post">
                @csrf
            <table class="w3-table w3-striped w3-hoverable w3-white view">
                <tr>
                    <th style="padding-top: 15px">Name</th>
                    <td style="padding-top: 15px">:</td>
                    <td>
                        <input id="nameInput" class="w3-input" type="text" name="name" value="{{\Illuminate\Support\Facades\Auth::user()->name}}" required readonly>
                    </td>
                    <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil" id="nameButton"></i></span></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>:</td>
                    <td colspan="2" style="padding-left: 17px">
                        {{\Illuminate\Support\Facades\Auth::user()->email}}
                    </td>

                </tr>
                <tr>
                    <th style="padding-top: 15px">Gender</th>
                    <td style="padding-top: 15px">:</td>
                    <td>
                        <input id="gInput" class="w3-input" type="text" name="gender" value="{{\Illuminate\Support\Facades\Auth::user()->gender}}" required readonly>

                    </td>
                    <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil" id="gButton"></i></span></td>
                </tr>
                <tr>
                    <th>User Type</th>
                    <td>:</td>
                    <td colspan="2" style="padding-left: 17px">{{\Illuminate\Support\Facades\Auth::user()->utype}}</td>
                </tr>

                <tr>
                    <th style="padding-top: 15px">Date of Birth</th>
                    <td style="padding-top: 15px">:</td>
                    <td>
                        <input id="bdayInput" class="w3-input" type="text" name="bday" value="{{date('d-m-Y', strtotime(Auth::user()->bday))}}" placeholder="d-m-y" required readonly>

                    </td>
                    <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil" id="bdayButton"></i></span></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td>:</td>
                    <td colspan="2" style="padding-left: 17px">{{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Auth::user()->bday)->diff(\Carbon\Carbon::now())->y}}</td>
                </tr>
                <tr>
                    <th style="padding-top: 15px">Phone</th>
                    <td style="padding-top: 15px">:</td>
                    <td>
                        <input id="phoneInput" class="w3-input" type="text" name="phone" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}" required readonly>
                    </td>
                    <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil"  id="phoneButton"></i></span></td>
                </tr>
                <tr><td colspan="4"></td></tr>
                <tr>
                    <td colspan="4">
                        <form>
                            @csrf
                            <button class="w3-button w3-block w3-black w3-hover-teal">Save Changes</button>
                        </form>
                    </td>
                </tr>

            </table>
            </form>
        </div>
    </div>

        @if(\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
            <hr>
            <div class="w3-row-padding">
                <h5><b>Professional Information</b></h5>
                <table class="w3-table w3-hoverable w3-striped w3-white">
                    <form action="/update" method="POST">
                        @csrf

                    @foreach($data as $d)
                    <tr>
                        <th>Department</th>
                        <td>:</td>
                        <td colspan="2">{{$d->dptname}}</td>
                    </tr>
                    <tr>
                        <th>Visiting Hour</th>
                        <td>:</td>
                        <td colspan="2">{{date("h:i A", strtotime($d->stime))}} to {{date("h:i A", strtotime($d->ftime))}}</td>
                    </tr>
                    <tr>
                        <th>Visiting Days</th>
                        <td>:</td>
                        <td colspan="2">
                            @if($d->sat)
                                Saturday<br>
                            @endif

                            @if($d->sun)
                                Sunday<br>
                            @endif

                            @if($d->mon)
                                Monday<br>
                            @endif

                            @if($d->tues)
                                Tuesday<br>
                            @endif

                            @if($d->wed)
                                Wednesday<br>
                            @endif

                            @if($d->thurs)
                                Thursday<br>
                            @endif

                            @if($d->fri)
                                Friday<br>
                            @endif
                        </td>
                    </tr>
                            <tr>
                                <th style="padding-top: 15px">Meeting Link</th>
                                <td style="padding-top: 15px">:</td>
                                <td>
                                    <input id="linkInput" class="w3-input" type="text" name="link" value="{{$d->link}}" required readonly>
                                </td>
                                <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil" id="linkButton"></i></span></td>
                            </tr>
                        <tr>
                            <th style="padding-top: 15px">Meeting Room ID</th>
                            <td style="padding-top: 15px">:</td>
                            <td>
                                <input id="codeInput" class="w3-input" type="text" name="code" value="{{$d->code}}" required readonly>
                            </td>
                            <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil" id="codeButton"></i></span></td>
                        </tr>
                            <tr>
                                <th style="padding-top: 15px">Meeting Password</th>
                                <td style="padding-top: 15px">:</td>
                                <td>
                                    <input id="pwInput" class="w3-input" type="text" name="pw" value="{{$d->pw}}" required readonly>
                                </td>
                                <td class="w3-center" style="padding-top: 15px"><span id='clickableAwesomeFont'><i class="fa fa-pencil" id="pwButton"></i></span></td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="4" class="w3-center">
                                <button class="w3-button  w3-black w3-hover-teal w3-right" style="width: 20%">Update</button>
                            </td>
                        </tr>
                    @endforeach
                    </form>
                </table>

            </div>
            <hr>

            @endif

<hr>

        <div class="w3-row-padding" style="width: 70%">
            <h5><b>Security Settings</b></h5>
            <table class="w3-table w3-white">
                <tr>
                    <td colspan="3">
                            <button class="w3-button w3-block w3-black w3-hover-teal collapsible">Change Password</button>
                       <div class="content">
                        <form class="w3-container" action="/changepassword" method="POST">
                            @csrf
                            <br>
                            <input class="w3-input" name="cpw" type="password" placeholder="Current Password" required><br>
                            <input class="w3-input" name="npw" type="password" placeholder="New Password (Minimum 8 Characters)" required><br>
                            <input class="w3-input" name="rnpw" type="password" placeholder="Re-Type New Password" required><br>
                            <button class="w3-button w3-black w3-right w3-hover-teal">Save New Password</button>
                        </form>
                    </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">

                            <button class="w3-button w3-block w3-black w3-hover-teal collapsible">Change Email</button>
                        <div class="content">

                                <form class="w3-container" action="/changemail" method="POST">
                                    @csrf
                                    <br>
                                    <input class="w3-input" name="cmail" type="email" placeholder="Current Email" required><br>
                                    <input class="w3-input" name="nmail" type="email" placeholder="New Email" required><br>
                                    <button class="w3-button w3-black w3-right w3-hover-teal">Save New Email</button>
                                </form>

                        </div>

                    </td>
                </tr>

            </table>
        </div>



    </div>
    </div>
</center>

<script>
    document.getElementById('nameButton').onclick = function() {
        document.getElementById('nameInput').removeAttribute('readonly');
    };

    document.getElementById('phoneButton').onclick = function() {
        document.getElementById('phoneInput').removeAttribute('readonly');
    };

    document.getElementById('gButton').onclick = function() {
        document.getElementById('gInput').removeAttribute('readonly');
    };

    document.getElementById('bdayButton').onclick = function() {
        document.getElementById('bdayInput').removeAttribute('readonly');
    };
    document.getElementById('linkButton').onclick = function() {
        document.getElementById('linkInput').removeAttribute('readonly');
    };
    document.getElementById('codeButton').onclick = function() {
        document.getElementById('codeInput').removeAttribute('readonly');
    };
    document.getElementById('pwButton').onclick = function() {
        document.getElementById('pwInput').removeAttribute('readonly');
    };

</script>


    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }

    </script>

<script type="text/javascript">
    function validateFileType(){
        var fileName = document.getElementById("filetype").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="gif"){
            //TO DO
        }else{
            alert("Only jpg/jpeg/gif/png files are allowed!");
            document.getElementById('filetype').value=null;
        }
    }
</script>

@endsection


