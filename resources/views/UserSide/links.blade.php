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
                <strong class="card-title">Links</strong>
                {!! Form::submit("Add Link", ['id'=>"addLinkButton",'class'=>'btn btn-primary mb-1 float-right',"data-toggle"=>"modal","data-target"=>"#createLink"]) !!}
      
            </div>
            <div class="table-stats order-table ov-h">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Link ID</th>
                            <th>URL Link</th>
                            <th>Team</th>
                            <th>Whatsapp Message</th>   
                            <th>Category</th>
                            <th>Action</th>
                            <th>Preview</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($links as $row){ 
                        ?>
                        <tr>
                            <td class='lnkID'>{{$row->linkID}}</td>
                            <td class='cpylink' style="">
                            
                            <a href="{{'https://'.$row->linkname.'.wazzap.my?'}}linkRedirect=1" >Normal Link</a>
                            <br>
                            <a href="{{'https://'.$row->linkname.'.wazzap.my?'}}linkRedirect=2" >Facebook Ads Link</a>
                            <br>
                            <a href="{{'https://'.$row->linkname.'.wazzap.my?'}}" >Facebook Ads Link with form</a>
                            
                         </td>
                            
                            <td>
                                <?php
                                if($row->teamID!=NULL){
                                $team = DB::select("select * from team_member where teamid = ".$row->teamID);
                                $str = '';
                                foreach($team as $t)
                                {
                                    $str = $str.$t->memberName." ";
                                }
                                echo $str;
                            }
                            else {
                                echo " ";
                            }
                                ?>

                            </td>
                            <td>{{$row->message}}</td>
                            <td>{{$row->category}}</td>
                            <td>
                                <button class="cpybtn btn btn-primary mb-1" data-clipboard-text="{{$row->linkname.'.wazzap.my'}}">
                                    Copy
                                </button>
                                {!! Form::submit('Edit', ["type"=>"button","class"=>"btn btn-primary mb-1 editLink","data-toggle"=>"modal","data-target"=>"#mediumModal"]) !!}
                                <input type='button' class = 'btn btn-primary mb-1 deleteClick' value='Delete'>
                            </td>
                            <td><a href = {{"https://".$row->linkname.".wazzap.my"}}>~</a></td>
                            <td>{{$row->updated_at}}</td>
                            
                       </tr>
                    <?php } ?>
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
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    

    <script>
        var clipboard = new ClipboardJS('.cpybtn');

clipboard.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);

    e.clearSelection();
});
        $('#mUrl').change(function(){
            debugger;
        }) ;

    </script>

    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Edit Link</strong>
                        </div>
                        <div class="card-body card-block">
                            
                            {{-- {!! Form::open(['action'=>'LinkController@edit','method'=>'POST']) !!} --}}
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class="form-control-label">Link ID</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id="mLinkID" class="form-control-static float-left">1234</p>
                                    </div>
                                </div>
                            <input type="text" id="linkID" name="id" class="d-none">

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">URL</label></div>
                                    <div class="col-12 col-md-4"><input type="text" id="mUrl" name="linkname"
                                            placeholder="Enter Link URL" class="form-control"></div>
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">.wazzap.my</label></div>
                                    <a href= "#" class = "previewLink">Preview</a>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Whatsapp Message</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserLname" name="lname"
                                            placeholder="Enter the Message" class="form-control"></div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            {{-- <strong class="card-title">Team</strong> --}}
                                            <div class="row form-group">    
                                                <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Select Team</label></div>
                                                <div class="col-12 col-md-9">
                                                    <select name="selectSm" id="selectSm" class="form-control-sm form-control">
                                                        <option value="0">Please select</option>
                                                        @foreach($teams as $team)
                                                    <option value={{$team->teamID}}>Team ID: {{$team->teamID}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-stats order-table ov-h">
                                            <table class="table tb1">
                                                <thead>
                                                    <tr>
                                                        <th>Phone</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Click Percentage</th>   
                                                        {{-- <th>Total Click</th> --}}
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class="form-control-label">Link ID</label>
                                                        </td>
                                                        <td>
                                                            <label class="form-control-label">Link ID</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" unchecked data-toggle="toggle">
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </td>
                                                       {{--  <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </td> --}}
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
                <button type="submit" id="Update" class="checkLink btn btn-primary">Confirm</button>
            </div>
            
        </div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="createLink" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Add Link</strong>
                        </div>
                        <div class="card-body card-block">
                                {!! Form::open(['action'=>'LinkController@create','method'=>'POST']) !!}
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">URL</label></div>
                                    <div class="col-12 col-md-4"><input type="text" id='LINKNAMEURL' name="linkname"
                                            placeholder="Enter Link URL" class="form-control"></div>
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">.wazzap.my</label></div>
                                    
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select"
                                            class=" form-control-label">Business Category</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="category" id="bCategory" class="form-control">
                                            <option value="0">Please select</option>
                                            <?php $cats = DB::select('select * from businesscategory')?>
                                            @foreach($cats as $cat)
                                                <option value="{{$cat->CategoryName}}">{{$cat->CategoryName}}</option>
                                            @endforeach
                                            

                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Whatsapp Message</label></div>
                                    <div class="col-12 col-md-9"><input type="text" name="message"
                                            placeholder="Enter the Message" class="form-control"></div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="Add"  class="checkLink btn btn-primary">Add</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<script>
        $('#mUrl').change(function(){
            $('.previewLink').attr("href","https://"+$('#mUrl').val()+".wazzap.my")
        }) ;
        $('.checkLink').click(function()
        {
            debugger
            var url = $('#LINKNAMEURL').val();
            if(/\W/.test(url))
            {
                alert('Url cannot contain symbols or spaces!!');
                return false;
            }
            return true;
        })
        

        //Populate Edit Form
        $('.editLink').click(function(){
            debugger
            var id={'id':$(this).parents('tr').find('td:nth-child(1)').text()};
            $.ajax({
                url: '/link',
                type:'POST',
                data: id,
                success:function(result){
                    var tableHtml='';
                    $('#mLinkID').text(result.linkID);
                    $('#mUrl').val(result.linkname);
                    $('#mUserLname').val(result.message);
                    $('.previewLink').attr('href','https://'+result.linkname+'.wazzap.my');
                    result.team.forEach(data => {
                        tableHtml+=`
                        <tr>                            <td>
                                                            <input type="text" class="form-control phoneNumber" disabled value="`+data.phoneNumber+`">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control MemberName" disabled value="`+data.memberName+`">
                                                        </td>
                                                        <td>`;
                                                            
                                                        if(data.status=="Active"){
                                                            tableHtml+= `<input type="checkbox" class="checkActive" checked data-toggle="toggle">`
                                                        }else{
                                                            tableHtml+= `<input type="checkbox" class="checkActive" unchecked data-toggle="toggle">`
                                                        }
                                                        tableHtml+=`
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control clickpecent" value="`+data.clickPercentage+`">
                                                                </div>
                                                            </div>
                                                        </td>
                                                  
                                                    </tr>
                        `
                    });
                    
                        /*   <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" disabled hidden class="form-control allowedclicks" value="`+data.AllowedClicks+`">
                                                                </div>
                                                            </div>
                                                        </td> */
                    $('.tb1').find('tbody').html(tableHtml);
    
                    debugger
                },
                error:function(error){
                    console.log(error)
                }

            })          
        })
        //Add new Row in Edit Form
        $('#addNew').click(function(){
            var newRow='';
            newRow+=`<tr>
                                                        <td>
                                                            <input type="text" disabled class="form-control phoneNumber">
                                                        </td>
                                                        <td>
                                                            <input type="text" disabled class="form-control MemberName">
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkActive" checked data-toggle="toggle">
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" class="form-control clickpecent">
                                                                </div>
                                                            </div>
                                                        </td>
                                                       
                                                    </tr>
`  ;
            $('.tb1').find('tbody').append(newRow);                                                
})
        $('#Update').click(function(){
            var count = 0;
            $('.clickpecent').each(function(index,value){
                count = count + parseInt(value.value);
            })
            if(count!=100)
            {
                alert('Percentages must add up to 100');
                return;
            }
            debugger
            var _Id=$('#mLinkID').text();
            var _Url=$('#mUrl').val();
            var _Message=$('#mUserLname').val();

            if(/\W/.test(_Url))
            {
                alert('Url cannot contain characters or spaces!!');
                return;
            }
            var teamArr=new Array();
            var editdata=new Array();
            $($('.tb1 tbody').find('tr')).each(function( index,value ) {
             teamArr.push({
                 phoneNumber: $(this).find('.phoneNumber').val(),
                 memberName: $(this).find('.MemberName').val(),
                 status: ($(this).find('input[type="checkbox"]').prop('checked') == true) ? "Active" : "off",
                 clickPercentage: $(this).find('.clickpecent').val(),
                 allowedClicks: $(this).find('.allowedclicks').val(),
             });
             
});
editdata.push({
                 id: _Id,
                 url: _Url,
                 message: _Message,
                 team: teamArr
             });
             debugger
              $.ajax({
                 url: '/link/edit',
                 type:'POST',
                 data: editdata[0],
                 success: function(result){
                    debugger
                     if(result==true){
                     location.reload();
                    }else{
                        alert('Oops! Something went wrong!!')
                    }
                 },
                 error:function(error){
                     console.log(error)
                 }
                
             }) 

console.log(editdata);
debugger

        })

        $('#selectSm').change(function(){
           teamId=$(this).children("option:selected").val();
           if(teamId <= 0 ){
               return
           }
           debugger
           $.ajax({
               url: '/getTeam',
               type: 'POST',
               data: {id: teamId},
               success:function(result){
                if(result.length < 1){
                    var noHtml='<tr><td>No records found </td></tr>'; 
                    $('.tb1').find('tbody').html(noHtml);   
                    return 
                }
                var tableHtml='';
                result.forEach(data => {
                tableHtml+=`
                        <tr>                            <td>
                                                            <input type="text" class="form-control phoneNumber" disabled name="phoneNumb" value="`+data.phoneNumber+`">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control MemberName" disabled name="memberName" value="`+data.memberName+`">
                                                        </td>
                                                        <td>`;
                                                        if(data.status=="Active"){
                                                            tableHtml+= `<input type="checkbox" name="check" class="checkActive" checked data-toggle="toggle">`
                                                        }else{
                                                            tableHtml+= `<input type="checkbox" name="check" class="checkActive" unchecked data-toggle="toggle">`
                                                        }
                                                        tableHtml+=`
                                                        </td>
                                                        <td>
                                                            <div class="row form-group">
                                                                <div class="col col-sm-12">
                                                                    <input type="text" name="click" class="form-control clickpecent" value="`+0+`">
                                                                </div>
                                                            </div>
                                                        </td>
                                                       
                                                    </tr>
                        `
                    });
                    
                    
                    $('.tb1').find('tbody').html(tableHtml);
    
               },
               error:function(error){
                   console.log(error);
               }

           })
        });

        $('.deleteClick').click(function(){
    let result = confirm("Are you sure?");
    if(result==true)
    {
        let data = $(this).parents('tr').find('.lnkID').text();
        debugger
        $.ajax(
            {
               url: '/link/destroy',
               type: 'POST',
               data: {id: data},
               success:function(result)
               {
                    location.reload();
               },
               error:function(error)
               {
                    console.log(error);
               }
            })
    }

})
</script>

    </body>

    </html>
    @endsection