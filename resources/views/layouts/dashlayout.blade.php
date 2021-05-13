<!DOCTYPE html>
<html>
@yield('title')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey" >


<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-teal" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
    <a href="{{url('/')}}" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-home w3-margin-right"></i>E-HealthCare</a>

    <form action="{{ route('logout') }}" method="post">
        @csrf
    <button class="w3-bar-item w3-button w3-right w3-hover-white">Logout</button>
    </form>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
        <div class="w3-col s4">
            @if(Auth::user()->pic)
                <a href="{{url('/home/profile')}}"><img src="{{asset('/storage/userimages/'.Auth::user()->pic)}}" alt="{{\Illuminate\Support\Facades\Auth::user()->name}}" class="w3-circle w3-margin-right" style="width:80px"></a>
            @else
                @if(Auth::user()->gender=='Male')
                    <a href="{{url('/home/profile')}}"><img src="/img/defaults/male.jpg" class="w3-circle w3-margin-right" style="width:80px"></a>
                @elseif(Auth::user()->gender=='Female')
                    <a href="{{url('/home/profile')}}"><img src="/img/defaults/female.jpg" class="w3-circle w3-margin-right" style="width:80px"></a>
                @else
                    <a href="{{url('/home/profile')}}"> <img src="/img/defaults/others.png" class="w3-circle w3-margin-right" style="width:80px"></a>
                @endif
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->utype=='Client'||\Illuminate\Support\Facades\Auth::user()->utype=='Doctor')
                <p style="margin-left: 20px">৳  {{\App\Balance::where(['email'=>\Illuminate\Support\Facades\Auth::user()->email])->value('balance')}}</p>
                @endif
        </div>
        <div class="w3-col s8 w3-bar">
            <p style="margin-left: 25px;margin-top: 40px">{{\Illuminate\Support\Facades\Auth::user()->name}}</p>

        </div>
    </div>
    <hr>


    <div class="w3-bar-block">


        <a href="{{url('/home')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Dashboard</a>

        @if(Auth::user()->utype=='Admin')
            <a href="{{url('/docrequests')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Doctor Requests</a>
            <a href="{{url('/topuprequests')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Top Up Requests</a>
            <a href="{{url('/cashoutrequests')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Cash Out Requests</a>
            <a href="{{url('/departments')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Departments</a>
            <a href="{{url('/adminlist')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Admin List</a>
            <a href="{{url('/doctorlist')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Doctor List</a>
            <a href="{{url('/clientlist')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Client List</a>
            <a href="{{url('/alltransactions')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  All Transactions</a>
            <a href="{{url('/allappointments')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  All Appointments</a>

        @endif

        @if(Auth::user()->utype=='Client' && \App\Balance::where('email',\Illuminate\Support\Facades\Auth::user()->email)->exists())

            <a href="{{url('/activedocs')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Doctors</a>

        @endif

        @if(Auth::user()->utype!='Admin' && \App\Balance::where('email',\Illuminate\Support\Facades\Auth::user()->email)->exists())
            <a href="{{url('/topup')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Top Up</a>
            <a href="{{url('/cashout')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Cashout</a>
            <a href="{{url('/appointmentsreport')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Appointments Report</a>
            <a href="{{url('/transactions')}}" class="w3-bar-item w3-button w3-padding w3-hover-teal"><i class="fa fa-arrow-right"></i>  Transaction History</a>
        @endif

    </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        @yield('header')
    </header>

    <div class="w3-container">
        @yield('content')

    <hr>

    <br>

</div>

    <div class="w3-center">
        @yield('pagination')
    </div>



    <!-- Footer -->
    <footer class="w3-container w3-padding-32 w3-black w3-center" >
        <h4>Follow Us on</h4>
        <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Facebook"><i class="fa fa-facebook"></i></a>
        <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Twitter"><i class="fa fa-twitter"></i></a>
        <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-google-plus"></i></a>
        <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-instagram"></i></a>
        <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Linkedin"><i class="fa fa-linkedin"></i></a>
        <p> <strong>E-HealthCare | Copyright &copy; 2021 </strong> <br> All rights reserved.</p>

    </footer>

<script>
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }
</script>
</div>
</body>
</html>
