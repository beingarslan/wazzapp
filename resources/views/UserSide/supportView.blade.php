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
        
    <label class="btn mb-1 float-right" style="padding-top: 1%;padding-left: 0%;">Plan: {{$PLAN}}</label>
    <label class="btn mb-1 float-right" style="padding-top: 1%;padding-left: 0%;">Type: {{Auth::user()->status}}</label>
        
        {!! Form::close() !!}
    </header>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><strong>Support</strong><small> Ticket</small></div>
            <div class="card-body card-block">
                {!! Form::open(["action"=>"SupportTicketController@store","method"=>"post"]) !!}
                <div class="form-group">
                    <label  class=" form-control-label">Subject</label>
                    <input name = "subject" type="text" placeholder="Enter Subject..." class="form-control">
                </div>
                <div class="form-group">
                <label  class=" form-control-label">Message</label>
                <textarea name="message" rows="9" placeholder="Enter Message..." class="form-control"></textarea>
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Support Tickets</strong>
            </div>
            <div class="table-stats order-table ov-h">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th style="text-align: left">Reply</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($supports as $row) 
                        {
                        ?>
                        <tr>
                            <td>{{$row->tkID}}</td>
                            <td>{{$row->subject}}</td>
                            <td>{{$row->description}}</td>
                            <td>{{$row->dateOpened}}</td>
                            <td>{{$row->status}}</td>
                            <td style="text-align: left">{{$row->reply}}</td>
                       </tr>
                    <?php  } ?>
            </tbody>
            </table>
        </div> 
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="/js/main.js"></script>
    </body>

    </html>
    @endsection