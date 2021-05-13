<!DOCTYPE html>
<html>
<title>{{config('app.name')}}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body id="myPage">


<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme-d2">
        <div class="w3-left-align">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-hover-white w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
            <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>E-HealthCare</a>
            <a href="#services" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Services</a>
            <a href="#goals" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Goals</a>
            <a href="#developers" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Developers</a>
            <a href="#contact" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
        </div>
        <div class="w3-right-align">
            @if(Route::has('login'))
                @auth

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="w3-bar-item w3-button w3-right w3-hide-small w3-hover-white">Logout</button>
                    </form>
                    <a href="{{ url('/home') }}" class="w3-bar-item w3-button w3-right w3-hide-small w3-hover-white">Dashboard</a>

                @else
                    <a href="{{ route('login') }}" class="w3-bar-item w3-button w3-right w3-hide-small w3-hover-white">Login</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="w3-bar-item w3-button w3-right w3-hide-small w3-hover-white">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium">
        @if(Route::has('login'))
            @auth
                 <a href="{{ url('/home') }}" class="w3-bar-item w3-button  w3-hover-white">Dashboard</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="w3-bar-item w3-button w3-hover-white">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w3-bar-item w3-button">Login</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="w3-bar-item w3-button">Register</a>
            @endif
            @endauth
            @endif
    </div>
</div>

<!-- Image Header -->

<div class="w3-display-container w3-animate-opacity">
    <img src="img/welcome.jpg" alt="E-HealthCare" style="width:100%;min-height:350px;max-height:600px;">
</div>

<!-- Service Row -->
<div class="w3-row-padding w3-center w3-padding-64 w3-theme" id="services">
    <h2>Our Services</h2>
    <div class="w3-quarter">
        <div class="w3-card w3-white">
            <a href="{{url('/home')}}">
            <img src="img/services/consultation.jpg" alt="consultation" style="width:100%" height="276"></a>
            <div class="w3-container">
                <h5>Online Consultation</h5>
            </div>
        </div>
    </div>

    <div class="w3-quarter">
        <div class="w3-card w3-white">
            <a href="{{url('/home')}}">
                <img src="img/services/support.png" alt="support" style="width:100%" height="276"></a>
            <div class="w3-container">
                <h5>Emergency Health Support</h5>
            </div>
        </div>
    </div>

    <div class="w3-quarter">
        <div class="w3-card w3-white">
            <a href="{{url('/home')}}">
                <img src="img/services/visit.jpg" alt="visit" style="width:100%" height="276"></a>
            <div class="w3-container">
                <h5>House Visit</h5>
            </div>
        </div>
    </div>

    <div class="w3-quarter">
        <div class="w3-card w3-white">
            <a href="{{url('/home')}}">
                <img src="img/services/nursing.jpg" alt="nursing" style="width:100%" height="276"></a>
            <div class="w3-container">
                <h5>Adult Nursing</h5>
            </div>
        </div>
    </div>

</div>

{{--<!-- Goals Row -->--}}
<div class="w3-row-padding w3-padding-64" id="goals">
    <div class="w3 w3-center w3-margin-bottom">
        <ul class="w3-ul w3-border w3-hover-shadow">
            <li class="w3-theme">
                <p class="w3-xlarge">Our Goals</p>
            </li>
            <li class="w3-padding-16">To provide essential health services and introduce innovative strategies of care both online and offline.</li>
            <li class="w3-padding-16">To augment care and service provided by hospitals and nursing homes by providing home health care.</li>
            <li class="w3-padding-16">To provide the highest quality and comprehensive healthcare in our clients’ homes.</li>
            <li class="w3-padding-16">To provide home health care services that promotes the patients’ value of life.</li>
            <li class="w3-padding-16">To provide qualified and skilled online services focusing on emergency basis.</li>

        </ul>
    </div>

</div>

<!-- Developer Container -->
<div class="w3-container w3-padding-64 w3-center" id="developers">
    <h2>Developer Team</h2>

    <div class="w3-row"><br>

        <div class="w3-center">
            <img src="img/developers/asif.jpg" alt="Asif" style="width:30%" class="w3-circle w3-hover-opacity">
            <h5>Md. Asif Hossain</h5>
        </div>
    </div>

</div>


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
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>
</body>
</html>
