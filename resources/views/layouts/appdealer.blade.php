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

    <!--data table css-->
    <link href="{{ asset('public/dealer/data_table/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" media="screen">
    <!--data table css-->

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Add icon library -->
    <!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ asset('public/back/img/favicon/favicon2.png') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('public/back/img/favicon/favicon2.png') }}" type="image/x-icon">
    <!-- Scripts -->
	<script src="{{ asset('public/js/app.js') }}" defer></script>
	<script src="{{ asset('public/back/js/jquery.min.js') }}"></script>    
        <!-- BOOTSTRAP JS -->
	<script src="{{ asset('public/back/js/bootstrap/bootstrap.min.js') }}"></script>
        
    <title>DSI Tyres Dealer Inventory Management System | @yield('title')</title>
    </head>
    
    <body>
    
    <section>
        <div class="container-fluid">
            <div class="row">
               @include('layouts.dealernavigation')

	<!-- Page Content -->
	<main>
		{{ $slot }}
	</main> 
             
                
                
                
            </div>
        </div>
    </section>
        
        <script src="{{ asset('public/dealer/js/bootstrap.bundle.min.js') }}"></script>



    <!-- Data table js files -->
    <!-- <script src="data_table/js/dataTables.bootstrap5.min.js"></script>
    <script src="data_table/js/jquery-3.5.1.js"></script>
    <script src="data_table/js/jquery.dataTables.min.js"></script> -->

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    	<!-- JQUERY VALIDATE -->
	<script src="{{ asset('public/back/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
    <!-- Data table js files -->

    <script>
        // Data table js
        $(document).ready(function () {
        $('#table_2').DataTable();
        });
    </script>
    {{ $script }}
    </body>  
    
    
</html>  
