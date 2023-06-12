<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('public/dealer/css/bootstrap.min.css') }}" rel="stylesheet">

    <!--main css-->
    <link href="{{ asset('public/dealer/css/dsi.css') }}" rel="stylesheet" type="text/css" media="screen">
    <!--main css-->

    <!--media query css-->
    <link href="{{ asset('public/dealer/css/mediaquery.css') }}" rel="stylesheet" type="text/css" media="screen">
    <!--media query css-->

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Add icon library -->
    <!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ asset('public/back/img/favicon/favicon2.png') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('public/back/img/favicon/favicon2.png') }}" type="image/x-icon">
    <title>DSI Tyres Dealer Inventory Management System | LOGIN</title>
  </head>
  
  <body>  
    <section id="login">
      <div class="container-fluid">
        <div class="row">
        <div class="col-lg-5 col-12">
          <div class="login_left">
            <div class="mob_login_title d-md-none d-block">
              <div class="mobile_logo pb-2"><img src="{{ asset('public/dealer/images/logo_colored.png') }}"></div> 
              <h1 class="pb-3">DEALER INVENTORY MANAGEMENT SYSTEM</h1>
            </div>
            <div class="heading_left">
            <p class="text-secondary">Welcome Back!</p>
            <h1>SIGN IN</h1>
            </div>
            <div>
              <form class="mt-4">
                <div class="mb-2">
                  <label for="InputEmail" class="form-label">Email address <span style="color: red;">*</span></label>
                  <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-2">
                  <label for="InputPassword" class="form-label">Password <span style="color: red;">*</span></label>
                  <input type="password" class="form-control" id="InputPassword" required>
                </div>
                <div class="text-end mb-2">
                  <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 login_btn">LOGIN</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-7 login_right d-sm-block d-none">
          <div class="login_right_content">
            <img src="{{ asset('public/dealer/images/logo-white.png') }}">
            <h1>DEALER INVENTORY MANAGEMENT SYSTEM</h1>
            <p style="color:white;">Your inventory, simplified. Log in to your dedicated portal to streamline your<br>inventory processes, optimize orders, and enhance your business efficiency.</p>
          </div>
        </div>
      </div>
      </div>
    </section>    

    <script src="{{ asset('public/dealer/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>