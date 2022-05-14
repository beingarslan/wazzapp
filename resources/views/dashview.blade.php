@extends('master')
@section('title','Dashboard')

@section('content')
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li class="menu-title">Dashboard</li><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="/dashboard" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Dashboard</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/user" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Users</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/broadcast" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-caret-square-o-right"></i>Broadcast</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/fundloadhistory" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Payment History</a>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="/plan" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/support" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-email"></i>Support</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href="./" style="width: 150px;float: left;"><img src="/logo.png" alt="Logo" >
                    
                </a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        {!! Form::open(['action'=>'MainController@logout']) !!}
        <input type="submit" class="btn btn-primary mb-1 float-right" value="Log out" style="margin-top: 0.7%;">
    {!! Form::close() !!}
    </header>


    @yield('dashcontent')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="/js/main.js"></script>

    </body>

    </html>
    @endsection