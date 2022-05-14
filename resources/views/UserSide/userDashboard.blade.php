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
                    <a href="/link" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-link"></i>Links</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/team" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-group"></i>Teams</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/linkanalytics" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-area-chart"></i>Link Analytics</a>
                </li>

                <li class="menu-item-has-children dropdown">
                <a href='/support' class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope"></i>Support</a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="/planUpgrade" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Upgrade Plan</a>
                </li>
                <div id = 'lnk' style="visibility: hidden;padding-left: 10%;">
                <li class="menu-item-has-children dropdown">
                    <p class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Plan: {{$PLAN}}</p>
                </li>
                <li class="menu-item-has-children dropdown">
                    <p class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Type: {{Auth::user()->status}}</p>
                </li>
            </div>
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
        
    <label class="btn mb-1" style="padding-top: 1%;padding-left: 0%;">Hi, welcome {{Auth::user()->firstname}}.</label>
    
        <input type="submit" class="btn btn-primary mb-1 float-right" value="Log out" style="margin-top: 0.7%;">
        
    <label class="btn mb-1 float-right" style="padding-top: 1%;padding-left: 0%;">Plan: {{$PLAN}}</label>
    <label class="btn mb-1 float-right" style="padding-top: 1%;padding-left: 0%;">Type: {{Auth::user()->status}}</label>
        
    {!! Form::close() !!}
    </header>
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-add-user"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text">
                                            <span class="count">
                                               {{$nteams}}
                                            </span>
                                        </div>
                                        <div class="stat-heading">Teams
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-link"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text">
                                            <span class="count">
                                               {{$links}}
                                            </span>
                                        </div>
                                        <div class="stat-heading">Links
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text">
                                            <span class="count">
                                               {{$linksClicked}}
                                            </span>
                                        </div>
                                        <div class="stat-heading">Clicks
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
             
        </div>
    </div>
    
    <!-- Scripts -->
    <?php $broadcasts = DB::select("SELECT * FROM `broadcast` WHERE CURDATE() BETWEEN startTime AND endTime;")?>
    
    <script>
     $(document).ready(function(){
         debugger
    

    toastr.options = {"closeButton": true,"debug": false,"newestOnTop": false,"progressBar": false,"positionClass": "toast-bottom-right",
  "preventDuplicates": false,"onclick": null,"showDuration": "300","hideDuration": "1000","timeOut": "5000",
  "extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
    @foreach($broadcasts as $row)
    toastr["info"]('{{$row->title}}', '{{$row->message}}')
    @endforeach     
});
    </script>
   
   <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        // $('.menutoggle').click(function() {
        //     if($(window).width() > 600)
        //     $('#lnk').toggle();
        // })
    </script>
    </body>

    </html>
    @endsection