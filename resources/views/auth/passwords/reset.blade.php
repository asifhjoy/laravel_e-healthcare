<!DOCTYPE html>
<html>
<head>

    <title>New Password</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

</head>

<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        margin-right: 10px;
        position: relative;
        z-index: 2;
    }
</style>

<body id="myPage">


<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme-d2">
        <div class="w3-left-align">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-hover-white w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
            <a href="{{url('/')}}" class="w3-bar-item w3-hover-white w3-button"><i class="fa fa-home w3-margin-right"></i>E-HealthCare</a>
        </div>
        <div class="w3-right-align">
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="w3-bar-item w3-right w3-button w3-hide-small w3-hover-white">Login</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="w3-bar-item w3-right w3-button w3-hide-small w3-hover-white">Register</a>
                @endif
            @endif
        </div>
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium">
        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="w3-bar-item w3-button w3-hover-white">Login</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="w3-bar-item w3-button w3-hover-white">Register</a>
            @endif
        @endif
    </div>
</div>
<center>


<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="w3-row-padding w3-padding-64 w3-margin" style="width: 40%; alignment: center">
        <div class="w3 w3-center">
            <ul class="w3-ul w3-border w3-hover-shadow">

                <li class="w3-theme">
                    <p class="w3-xlarge">Recover Password</p>
                </li>

                <li class="w3-padding-16">
                    <input type="email"
                           name="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           placeholder="Email">

                    @if ($errors->has('email'))
                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </li>

                <li class="w3-padding-16">
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           placeholder="New Password">
                    <i class="far fa-eye field-icon" id="togglePassword"></i>


                @if ($errors->has('password'))
                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                    @endif
                </li>

                 <li class="w3-padding-16">
                    <input type="password"
                           id="passwordconfirmation"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Confirm Password">
                     <i class="far fa-eye field-icon" id="togglePasswordconfirmation"></i>
                    @if ($errors->has('password_confirmation'))
                        <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                <li class="w3-padding-16">
                    <div align="right">
                        <button type="submit" class="w3-button w3-black w3-round-large w3-hover-teal">Reset Password</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</form>
</center>

<div class="w3-container w3-padding-64 w3-theme-l5" id="contact">
    <div class="w3-row">
        <div class="w3-col m5">
            <div class="w3-padding-16"><span class="w3-xlarge w3-border-teal w3-bottombar">Contact Us</span></div>
            <p>Swing by for a cup of coffee or tea.</p>
            <p><i class="fa fa-map-marker w3-text-teal w3-xlarge"></i>  xxxxx<br>      xxxxx</p>
            <p><i class="fa fa-phone w3-text-teal w3-xlarge"></i>  +880 xxxxxxxxxx</p>
            <p><i class="fa fa-envelope w3-text-teal w3-xlarge"></i>  corporate@e-healthcare.com</p>
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
      <p style="margin-top: 15px"> <strong>E-HealthCare | Copyright &copy; 2021 </strong> <br> All rights reserved.</p>

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

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

    const togglePasswordconfirmation = document.querySelector('#togglePasswordconfirmation');
    const passwordconfirmation = document.querySelector('#passwordconfirmation');

    togglePasswordconfirmation.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = passwordconfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordconfirmation.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });



</script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>



