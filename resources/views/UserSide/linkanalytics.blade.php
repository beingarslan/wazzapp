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
        <input type="submit" class="btn btn-primary mb-1 float-right"  value="Log out" style="margin-top: 0.7%;">
        
    <label class="btn mb-1 float-right" style="padding-top: 1%;padding-left: 0%;">Plan: {{$PLAN}}</label>
    <label class="btn mb-1 float-right" style="padding-top: 1%;padding-left: 0%;">Type: {{Auth::user()->status}}</label>
        
        {!! Form::close() !!}
    </header>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Link Analytics</strong>
            </div>
            <div class="table-stats order-table ov-h">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Link ID</th>
                            <th>URL Link</th>
                            <th>Team</th>
                            <th>All Click</th>
                            <th>Business Category</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($links as $row) 
                        {
                            if($row->teamID==NULL)
                            continue;
                            $countTeamMembers = DB::select("SELECT count(*) as cnt FROM team_member WHERE TEAMID = ".$row->teamID);
                            $teamMembers = DB::select("SELECT * FROM team_member WHERE TEAMID = ".$row->teamID);
                            
                            for($i=0;$i<$countTeamMembers[0]->cnt;$i++){
                        ?>
                        @if($i==0)
                        <tr>
                            <td class='linkID'>{{$row->linkID}}</td>
                            <td style = "text-transform: lowercase"><a href={{"https://".$row->linkname.".wazzap.my"}}>{{"https://".$row->linkname.".wazzap.my"}}</a></td>
                            <td>{{$teamMembers[$i]->memberName}}</td>
                            <td>{{$teamMembers[$i]->clicks}}</td>
                            <td>{{$row->category}}</td>
                            <td><input type='button' class = 'btn btn-primary mb-1 DownloadInfo' value='Download'></td>
                            
                       </tr>
                       @else
                       <tr>
                        <td></td>
                        <td></td>
                        <td>{{$teamMembers[$i]->memberName}}</td>
                        <td>{{$teamMembers[$i]->clicks}}</td>
                        <td>{{$row->category}}</td>
                        <td>{{""}}</td>
                        </tr>
                        @endif
                    <?php } ?>
                    <?php } ?>
            </tbody>
            </table>
        </div> 
    </div>
    </div>
    <script>
        $('.DownloadInfo').click(function(){
            debugger
            var id = $('.linkID')[0].outerText;
            $.ajax({
                url:'/getLinkInfo',
                type:'POST',
                data:{id:id},
                success:function(result){
                    debugger
                    
            var doc = new jsPDF()
            doc.autoTable({
            columnStyles: { europe: { halign: 'center' } }, 
            body: result,
            columns: [
                { header: 'URL', dataKey: 'linkname' },
                { header: 'Category', dataKey: 'cat' },
                { header: 'Name', dataKey: 'Name' },
                { header: 'Phone No.', dataKey: 'Phone' },
                { header: 'Email', dataKey: 'memberEmail' },//This is not member email...This is clicker's email
                { header: 'Date', dataKey: 'updated_at' },
            ],
            })
            doc.save('table.pdf')
                },
                error:function(error)
                {
                    console.log(error);
                }
            })
        })
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable"></script>
    </body>

    </html>
    @endsection