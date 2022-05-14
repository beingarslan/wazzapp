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
            <div class="card-header">
                <strong class="card-title">Team Members</strong>
                {!! Form::submit("Add Team", ['id'=>"addTeamButton",'class'=>'btn btn-primary mb-1 float-right']) !!}
            </div>
            <div class="table-stats order-table ov-h">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Team ID</th>
                            <th>Name</th>
                            <th>Phone No. </th>
                            <th>Bank Name</th>
                            <th>Bank Account</th>
                            <th>Action</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        foreach ($teams as $row) 
                        {
                            $count = 0;
                        ?> 
                        @if(count($row->teamMembers)!=0)
                        <tr>
                        <td>{{$row->teamID}}</td>
                        <td>{{$row->teamMembers[0]->memberName}}</td>
                        <td>{{$row->teamMembers[0]->phoneNumber}}</td>
                        <td>{{$row->teamMembers[0]->BankName}}</td>
                        <td>{{$row->teamMembers[0]->AccountNumber}}</td>
                        <td>   {!! Form::submit('Edit', ["type"=>"button","class"=>"btn btn-primary mb-1 editTeam","data-toggle"=>"modal","data-target"=>"#mediumModal"]) !!}
                            {!! Form::submit('Delete', ["type"=>"button","class"=>"btn btn-primary mb-1 deleteTeam"]) !!}
                      
                        </td>
                        <td>{{$row->teamMembers[0]->updated_at}}</td>
                        </tr> 
                        @else
                        <tr>
                            <td>{{$row->teamID}}</td>
                            <td>{{""}}</td>
                            <td>{{""}}</td>
                            <td>{{""}}</td>
                            <td>{{""}}</td>
                            <td>   {!! Form::submit('Edit', ["type"=>"button","class"=>"editTeam btn btn-primary mb-1","data-toggle"=>"modal","data-target"=>"#mediumModal"]) !!}
                                {!! Form::submit('Delete', ["type"=>"button","class"=>"deleteTeam btn btn-primary mb-1"]) !!}
                             
                            </td>
                            <td>{{""}}</td>
                            
                        </tr> 
                        <?php $x = 123 ?>
                        @endif
                        @foreach($row->teamMembers as $member)

                        @if($count != 0) 
                        <tr>
                        <td></td>
                        <td>{{$member->memberName}}</td>
                        <td>{{$member->phoneNumber}}</td>
                        <td>{{$member->BankName}}</td>
                        <td>{{$member->AccountNumber}}</td>
                        <td></td>
                        <td>{{$member->updated_at}}</td>
                        </tr>
                        @endif
                        <?php $count++; ?>
                        @endforeach
                    <?php    
                        } 
                    ?>
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
    <script>
        $('#addTeamButton').click(function()
        {
            $.ajax({
                url:'/teamMembers/create',
                type:'POST',
                success:function(result)
                {
                    if(result=='TEAMLIMIT')
                    {
                        alert("Team Limit Exceeded!! Please upgrade your Plan!!");  
                    }
                    location.reload();
                },
                error:function(error)
                {
                    console.log(error);
                }
        })
    })
    </script>
    <script>
        $('.deleteTeam').click(function(){
            let result = confirm("Are you sure?");
            if(result==false)
            {
                return;
            }
            var id = $(this).parents('tr').find('td:nth-child(1)').text();
            $.ajax({
                url:'/teamMembers/destroy',
                type:'POST',
                data:{id:id},
                success:function(result){
                    debugger
                    location.reload();
                },
                error:function(error)
                {
                    console.log(error)
                }
            })
        })
    </script>
    <script>
        $('.editTeam').click(function()
        {
            $('#mTeamID').text($(this).parents('tr').find('td:nth-child(1)').text())
            var id={'id':$(this).parents('tr').find('td:nth-child(1)').text()};
            $.ajax({
                url: '/teamMembers',
                type:'POST',
                data: id,
                success:function(result)
                {debugger
                    var html='';
                    if(result.length> 0){
                        result.forEach(member => {
                            
                        
                                            html+=`
                    <tr>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="`+member.memberName+`" class="form-control memname">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="`+member.phoneNumber+`" class="form-control memphone" >
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="`+member.BankName+`" class="form-control membank">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="`+member.AccountNumber+`" class="form-control memacc">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" disabled value="`+member.clicks+`" class="form-control memclicks">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                    </tr>
                    `   
                    })
                }

                    $('.tb1 tbody').html(html);
                },
                error:function(error)
                {
                    console.log(error);
                }
            })
        })

        //edit ajax call
       
    </script>
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Edit Team</strong>
                        </div>
                        <div class="card-body card-block">
                            {{-- {!! Form::open(['action'=>'LinkController@edit','method'=>'POST']) !!} --}}
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class="form-control-label">Team ID</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id="mTeamID" class="teamID form-control-static float-left">1234</p>
                                    </div>
                                </div>
                            <input type="text" id="teamID" name="id" class="d-none">

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                         <strong class="card-title">Team</strong> 
                                         <input type="button" class="btn btn-sm btn-primary" id="addRow" style="    float: right;" value="Add">
                                        </div>
                                        <div class="table-stats order-table ov-h">
                                            <table class="table tb1">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Bank Name</th>
                                                        <th>Bank Account</th>
                                                        <th>Clicks</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>  
                        </div>
                       
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" onclick="event.preventDefault()" id="" class="confirmButton btn btn-primary">Confirm</button>
                <button id='Update' hidden></button>
            </div>
            
        </div>
</div>
</div>
</div>
</div>
<script>
    $('.confirmButton').click(function()
    {
        debugger
        if($('.memphone').length == 1)
        {
            var phone = $('.memphone').val();
            if(!phone.startsWith('+60'))
            {
               alert('Your phone number must start with +60');
                return false;
            }
            else if(/([A-Z]|[a-z])/.test(phone))
            {
                alert('Your phone number must contain numbers only!!');
                return false;
            }
        }
        else
        {       
            for(var i=0;i<$('.memphone').length;i++)
            {
                var phone = $('.memphone')[i].value;
                if(!phone.startsWith('+60'))
                {
                    alert('Your phone number must start with +60');
                    return false;
                }
                else if(/([A-Z]|[a-z])/.test(phone))
                {
                    alert('Your phone number must contain numbers only!!');
                    return false;
                }
            }
        }
        $('#Update').trigger('click');
        return true;
    })
//add row
$("#addRow").click(function(){
    var html=`
    <tr>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="" class="form-control memname">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="" class="form-control memphone" >
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="" class="form-control membank">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="" class="form-control memacc">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" value="0" disabled class="form-control memclicks">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                   
    `;
    $('.tb1 tbody').append(html)
})
    //update click
     $('#Update').click(function(){
            debugger
            var memberArr= new Array();
            $.each($('.tb1 tbody').find('tr'),function(index,value){
            memberArr.push({
                'teamid':$('.teamID')[0].outerText,
                'memberName': $(this).find('.memname').val(),
                'memberPhone': $(this).find('.memphone').val(),
                'memberBank': $(this).find('.membank').val(),
                'memberAccount': $(this).find('.memacc').val(),
                'memberClicks': $(this).find('.memclicks').val(),
                
        }) 

})
//ajax call

$.ajax({
    url: '/teamMembers/edit',
    type: 'POST',
    data: {data:memberArr},
    success:function(result){
        debugger;
        location.reload();
    },
    error:function(err){
        console.log(err)
    }
})

console.log(memberArr)
  
        })
        
        
</script>
<?php
    if(isset($x))
    {
        
?>
<script>
    $($('.editTeam')[$('.editTeam').length-1]).trigger('click')
</script>
<?php }?>
    </body>

    </html>
    @endsection