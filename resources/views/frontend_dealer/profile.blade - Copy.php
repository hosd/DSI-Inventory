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
    <section>
      <div class="container-fluid">
        <div class="row">

                <!-- Desktop Menu Start -->
                <div class="sidebar_menu col-lg-2 col-md-4 bg-dark vh-100 px-0 d-md-block d-none">
                    <!-- <div class="sidebar_menu_content"> -->
                    <div class="py-3 ps-2"><img src="{{ asset('public/dealer/images/dsi-logo-white-db.png') }}"></div>    
                    <ul class="px-0 " style="list-style:none;">
                        <li class="menu_li"><a class="d-flex" href="#"><span><img src="{{ asset('public/dealer/images/view-dashboard.svg') }}"></span>Dashboard</a></li>
                        <li>
                            <div class="accordion sidebar_accordion accordion-flush" id="accordionFlush">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <span><img src="{{ asset('public/dealer/images/order-details.svg') }}"></span>Online order management
                                    </button>
                                  </h2>
                                  <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
                                    <div class="accordion-body">
                                        <ul class="">
                                            <li class="acc_body_li" class="acc_body_li"><a class="" href="#">Pickup Pending Orders</a></li>
                                            <li class="acc_body_li"><a class="" href="#">Completed Orders</a></li>
                                            <li class="acc_body_li"><a class="" href="#">Cancelled orders</a></li>
                                          </ul>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </li>
                        <li class="menu_li"><a class="d-flex" href="#"><span><img src="{{ asset('public/dealer/images/document.svg') }}"></span>Invoice management</a></li>
                        <li class="menu_li"><a class="d-flex" href="#"><span><img src="{{ asset('public/dealer/images/stickies.svg') }}"></span>Stock management</a></li>
                        <li class="active menu_li"><a class="d-flex" href="#"><span><img src="{{ asset('public/dealer/images/Vector.svg') }}"></span>Profile management</a></li>
                        <li class="menu_li"><a class="d-flex" href="#"><span><img src="{{ asset('public/dealer/images/list.svg') }}"></span>Current User List</a></li>
                    </ul>
                    <!-- </div> -->
                </div>
                <!-- Desktop Menu End -->

                <div class="db_right col-lg-10 col-md-8 col-12 px-0 bg-light">
                    <div class="sticky_header bg-white">
                        <div class="m-auto row">
                        <div class="d-md-none d-block col-6 d-flex">
                            <div>
                                <a class="btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                    <span><img src="{{ asset('public/dealer/images/hamburger_icon.svg') }}" alt=""></span>
                                </a>      
                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header">
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>

                                <!-- Mobile Menu Start -->
                                <div class="mobile_menu offcanvas-body">
                                    <ul class="px-0 " style="list-style:none;">
                                        <li class="menu_li"><a href="#"><span><img src="{{ asset('public/dealer/images/view-dashboard.svg') }}"></span>Dashboard</a></li>
                                        <li>
                                            <div class="accordion sidebar_accordion accordion-flush" id="accordionFlush">
                                                <div class="accordion-item">
                                                  <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                        <span><img src="{{ asset('public/dealer/images/order-details.svg') }}"></span>Online order management
                                                    </button>
                                                  </h2>
                                                  <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
                                                    <div class="accordion-body">
                                                        <ul class="bg-dark">
                                                            <li class="acc_body_li"><a  href="#">Pickup Pending Orders</a></li>
                                                            <li class="acc_body_li"><a href="#">Completed Orders</a></li>
                                                            <li class="acc_body_li"><a href="#">Cancelled orders</a></li>
                                                          </ul>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="menu_li"><a href="#"><span><img class="icon_img" src="{{ asset('public/dealer/images/document.svg') }}"></span>Invoice management</a></li>
                                        <li class="menu_li"><a href="#"><span><img class="icon_img" src="{{ asset('public/dealer/images/stickies.svg') }}"></span>Stock management</a></li>
                                        <li class="active menu_li"><a href="#"><span><img class="icon_img" src="{{ asset('public/dealer/images/Vector.svg') }}"></span>Profile management</a></li>
                                        <li class="menu_li"><a href="#"><span><img class="icon_img" src="{{ asset('public/dealer/images/list.svg') }}"></span>Current User List</a></li>
                                    </ul>
                                </div>
                                <!-- Mobile Menu End -->

                                </div>
                            </div>
                            <div class="mobile_logo"><img src="{{ asset('public/dealer/images/logo_colored.png') }}"></div> 
                        </div>
                        <div class="col-lg-12 col-6 text-end">
                            <a href="#"><img src="{{ asset('public/dealer/images/account.svg') }}"></a>
                            <a href="#"><img src="{{ asset('public/dealer/images/logout.svg') }}"></a>
                        </div>
                    </div>
                    </div>
                    <div style="background-color: black;">
                        <h2 class="heading_text text-white ps-4">Profile Management</h2>
                    </div>
                    <div class="user_details row">
                        <div class="col-lg-6 col-12">
                            <form>
                                <div class="mb-3">
                                     <label for="InputName" class="form-label">Name</label>
                                     <input type="text" class="form-control" id="InputName" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="InputEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp">
                                </div>
                              </form>
                        </div>
                        <div class="col-lg-6 col-12">
                            <form>
                                <div class="mb-3">
                                     <label for="InputAddress" class="form-label">Address</label>
                                     <input type="text" class="form-control" id="InputAddress">
                                </div>
                                <div class="mb-3">
                                    <label for="InputPhone" class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control" id="InputPhone">
                                </div>
                              </form>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary text-end">Submit</button>
                        </div>
                    </div>
                    
                </div>
                
                
            </div>
      </div>
    </section>    

    <script src="{{ asset('public/dealer/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Data table js files -->
    <!-- <script src="data_table/js/dataTables.bootstrap5.min.js"></script>
    <script src="data_table/js/jquery-3.5.1.js"></script>
    <script src="data_table/js/jquery.dataTables.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Data table js files -->

    <script>
        // Data table js
        $(document).ready(function () {
        $('#table_2').DataTable();
        });
    </script>
  </body>
</html>