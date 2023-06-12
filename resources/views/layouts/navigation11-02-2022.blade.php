<nav x-data="{ open: false }" class="">
    <!-- Primary Navigation Menu -->
    <!-- HEADER -->
    <header id="header">
        <div id="logo-group">

            <!-- PLACE YOUR LOGO HERE -->
            <h1 class="hidden-xs" style="font-weight: 900; color: #3b2c46; font-size: 18px; padding-top: 16px; padding-left: 10px;"><img src="{{ asset('public/back/img/gov_logo.png') }}" alt="Labour Managment System" style="position: relative; top: -6px; width: 21px; float: left; padding-right: 12px;"> Complaint Management System - Department of Labour</h1>
            <span id="logo" class="visible-xs"> <img src="{{ asset('public/back/img/mobile_labor_logo.svg') }}" alt="Labour Managment System"> </span>
            <!-- END LOGO PLACEHOLDER -->

            <!-- Note: The activity badge color changes when clicked and resets the number to 0
				Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
            <!-- <span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span> -->

        </div>

        <!-- pulled right: nav area -->
        <div class="pull-right">

            <!-- collapse menu button -->
            <div id="hide-menu" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
            </div>
            <!-- end collapse menu -->

            <!-- #MOBILE -->
            <!-- Top menu profile link : this shows only when top menu is active -->
            <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
                <li class="">
                    <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                        <img src="{{ asset('public/back/img/avatars/sunny.png') }}" alt="John Doe" class="online" />
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="login.html" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- logout button -->
            <div id="logout" class="btn-header transparent pull-right">
                <span>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();" style="padding: 6px 7px; margin-top: 10px; border: 1px solid #bfbfbf !important; background-color: #f8f8f8 !important; font-size: 16px;">
                            <i class="fa fa-sign-out login_sign"></i>
                        </x-dropdown-link>
                    </form>
                </span>
            </div>
            <!-- end logout button -->

            <!-- search mobile button (this is hidden till mobile view port) -->
            <div id="search-mobile" class="btn-header transparent pull-right hidden">
                <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
            </div>
            <!-- end search mobile button -->


            <!-- fullscreen button -->
            <div id="fullscreen" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
            </div>
            <!-- end fullscreen button -->

            <!-- multiple lang dropdown : find all flags in the flags page -->
            <?php /* <div class="relative inline-block text-left">
                <li class="nav-item dropdown" style="list-style: none; margin-top: 15px;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 8px; border: 1px solid #bfbfbf; background-color: #f8f8f8; font-size: 12px;">
                        {{ Config::get('languages')[App::getLocale()] }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="padding: 10px;">
                        @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                        <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a><br>
                        @endif
                        @endforeach
                    </div>
                </li>
            </div> */ ?>
            @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
            <div class="relative inline-block text-left">
                <li class="nav-item" style="list-style: none; margin-top: 15px;">
                    <a class="nav-link dropdown-toggle" href="{{ route('lang.switch', $lang) }}" id="navbarDropdownMenuLink"   style="padding: 6px 8px; border: 1px solid #bfbfbf; background-color: #f8f8f8; font-size: 12px;">
                        {{$language}}
                    </a>

                </li>
            </div>
             @endif
                        @endforeach
				<!-- end multiple lang -->



        </div>
        <!-- end pulled right: nav area -->

    </header>
    <!-- END HEADER -->


    <!-- Left panel : Navigation area -->
    <!-- Note: This width of the aside area can be adjusted through LESS variables -->
    <aside id="left-panel">

        <!-- User info -->
        <div class="login-info">
            <span>
                <!-- User image size is adjusted inside CSS, it should stay as it -->

                 <!-- <a href="href="{{ route('profile') }}"" id="show-shortcut" data-action="toggleShortcut">-->
                 <a href="{{ route('profile') }}" >
                    <img src="{{ asset('public/back/img/avatars/sunny.png') }}" alt="me" class="online" />
                    <span>
                    {{ auth()->user()->name }}
                    </span>
                    <i class="fa fa-angle-down"></i>
                </a>

            </span>
        </div>
        <!-- end user info -->

        <!-- NAVIGATION : This navigation is also responsive-->
        <nav>
            <!--
    NOTE: Notice the gaps after each icon usage <i></i>..
    Please note that these links work a bit different than
    traditional href="" links. See documentation for details.
    -->


            <ul>
                <li class="active open">
                    <a href="{{ route('dashboard') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
                    <!--<ul style="display: block;">
                        <li class="active">
                            <a href="{{ route('profile') }}" title="Dashboard"><span class="menu-item-parent">{{ __('My Profile') }}</span></a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">Manage Users</a>
                        </li>
                        <li>
                            <a href="{{ route('roles.index') }}">Manage Role</a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}">Manage Product</a>
                        </li>
                    </ul>-->
                </li>
                @foreach($menuItems as $item)
                <li >

                    @if(in_array( $item->id,$arrParentID))
                    <a href="#"><i class="{{ $item->icon }}"></i> <span class="menu-item-parent">{{ $item->title }}</span></a>

                    @if(count($subMenuItems)>0)
                    <ul>
                        @foreach($subMenuItems as $subMenu)
                        @if($item->id==$subMenu->parent_id)
                        <li>
                            @if(in_array( $subMenu->id,$permissionHave))
                            <a href="{{ route( $subMenu->url ) }}">{{ $subMenu->title }}</a>
                            @endif
                        </li>
                        @endif
                        @endforeach
                    </ul>
                    @endif

                    @elseif($item->is_parent == 0)
                    <a href="{{ route( $item->url ) }}"><i class="{{ $item->icon }}"></i> <span class="menu-item-parent">{{ $item->title }}</span></a>
                    @endif
                </li>
                @endforeach

                <li>
                    <a href="{{ route('user-manual') }}" title="User Manual"><i class="fa fa-lg fa-fw fa-file"></i> <span class="menu-item-parent">User Manual</span></a>
                </li>

            </ul>
        </nav>


        <!-- <span class="minifyme" data-action="minifyMenu">
    <i class="fa fa-arrow-circle-left hit"></i>
</span>-->

    </aside>
    <!-- END NAVIGATION -->

</nav>
