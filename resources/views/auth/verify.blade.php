<!DOCTYPE html>
<html>
<title>{{config('app.name')}} | Verify</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<body id="myPage">


<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme-d2">
        <div class="w3-left-align">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-hover-white w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
            <a href="{{url('/')}}" class="w3-bar-item w3-button w3-hover-white"><i class="fa fa-home w3-margin-right"></i>E-HealthCare</a>
        </div>
        <div>
            @if(Route::has('login'))
                @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="w3-bar-item w3-button w3-right w3-hover-white">Logout</button>
                    </form>
                @endauth
            @endif
        </div>
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium">
        @if(Route::has('login'))
            @auth
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="w3-bar-item w3-button w3-hover-white">Logout</button>
                </form>
            @endauth
        @endif
    </div>
</div>

<!-- Image Header -->



<!-- Work Row -->


<center>
<div class="w3-row-padding w3-padding-64 w3-margin" style="width: 60%">
    <div class="w3 w3-center">
        <ul class="w3-ul w3-border w3-hover-shadow">
            <li class="w3-theme">
                <p class="w3-xlarge">Please Verify Your Email Address First</p>
            </li>
            <li class="w3-padding-16"></li>
            <li class="w3-padding-16">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">A fresh verification link has been sent to
                        your email address
                    </div>
                @endif
            </li>
            <li class="w3-padding-16"><h3>Before proceeding, Please check your Email for a Verification Link. If you did not receive the email</h3></li>
            <li class="w3-padding-16">
                <form method="post" action="{{route('verification.resend')}}">
                    @csrf
                    <button class="w3-button w3-medium w3-hover-teal w3-black w3-round-large">Click Here</button>
                </form>
            </li>
        </ul>
    </div>

</div>
</center>

<!-- Container -->


<!-- Contact Container -->
<div class="w3-container w3-padding-64 w3-theme-l5" id="contact">
    <div class="w3-row">
        <div class="w3-col m5">
            <div class="w3-padding-16"><span class="w3-xlarge w3-border-teal w3-bottombar">Contact Us</span></div>
            <p>Swing by for a cup of coffee or tea.</p>
            <p><i class="fa fa-map-marker w3-text-teal w3-xlarge"></i>  xxxxx<br>     xxxxx</p>
            <p><i class="fa fa-phone w3-text-teal w3-xlarge"></i>  +880 xxxxxxxxxx</p>
            <p><i class="fa fa-envelope-o w3-text-teal w3-xlarge"></i>  corporate@e-healthcare.com</p>
        </div>
        <div class="w3-col m7">
            <form class="w3-container w3-card-4 w3-padding-16 w3-white" action="/action_page.php" target="_blank">
                <div class="w3-section">
                    <input class="w3-input" type="text" name="Name" placeholder="Name" required>
                </div>
                <div class="w3-section">
                    <input class="w3-input" type="text" name="Email" placeholder="Email" required>
                </div>
                <div class="w3-section">
                    <input class="w3-input" type="text" name="Message" placeholder="Message" required>
                </div>
                <input class="w3-check" type="checkbox" checked name="Like">
                <label>I Like it!</label>
                <button type="submit" class="w3-button w3-right w3-theme">Send</button>
            </form>
        </div>
    </div>
</div>



<!-- Footer -->
<footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
    <h4>Follow Us on</h4>
    <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Facebook"><i class="fa fa-facebook"></i></a>
    <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Twitter"><i class="fa fa-twitter"></i></a>
    <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-google-plus"></i></a>
    <a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-instagram"></i></a>
    <a class="w3-button w3-large w3-teal w3-hide-small" href="javascript:void(0)" title="Linkedin"><i class="fa fa-linkedin"></i></a>
    <p> <strong>E-HealthCare | Copyright &copy; 2021 </strong> <br> All rights reserved.</p>

    <div style="position:relative;bottom:100px;z-index:1;" class="w3-tooltip w3-right">
        <a class="w3-button w3-theme" href="#myPage"><span class="w3-xlarge">
    <i class="fa fa-chevron-circle-up"></i></span></a>
    </div>
</footer>

<script>
    // Script for side navigation
    function w3_open() {
        var x = document.getElementById("mySidebar");
        x.style.width = "300px";
        x.style.paddingTop = "10%";
        x.style.display = "block";
    }

    // Close side navigation
    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
    }

    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }
</script>

</body>
</html>
