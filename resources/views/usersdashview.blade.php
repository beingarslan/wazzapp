@extends("dashview")
@section("dashcontent")
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Users</strong>
            {!! Form::submit("Add User", ['id'=>"createUserButton",'class'=>'btn btn-primary mb-1 float-right',"data-toggle"=>"modal","data-target"=>"#createUser"]) !!}
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="">Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Status</th>
                        <th>Plan</th>
                        <th>Date</th>
                       
                        <th>Link Clicks</th>
                        <th>Last Login</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($res as $row) {
                    ?>
                    <tr>
                        <td class="userId">{{$row->userID}}</td>
                        <td class="userName">{{$row->firstname . " " . $row->lastname}}</td>
                        <td class="userEmail">{{$row->email}}</td>
                        <td class="userPhone">{{$row->phone}}</td>
                        <td class="userStatus">{{$row->status}}</td>
                        <?php 
                                foreach($allplans as $plan)
                                {
                                    if($plan->planID == $row->planID)
                                    {
                                        $userPlanInfo=$plan->PlanTitle;
                                    break;
                                    }
                                }
                            ?>
                        <td class="userPlan">{{$userPlanInfo}}</td>
                        <td class="userDate">{{$row->dateStart . " ".$row->dateEnd}}</td>
                       
                        <?php $links = DB::select("SELECT SUM(CLICKS) as cnt FROM team_member WHERE TEAMID in(SELECT TEAMID FROM links WHERE USERID = " . $row->userID . ")"); ?>
                        <td class="userLinks">{{$links[0]->cnt}}</td>
                        <td>{{$row->lastLogin}}</td>
                        <td>
                            {!! Form::submit('Edit', ["type"=>"button","id"=>'editUser',"class"=>"btn btn-primary mb-1 editUser","data-toggle"=>"modal","data-target"=>"#mediumModal"]) !!}
                            <button type="button" onclick="autologon({{$row->userID}})" class="btn btn-primary">Auto-login</button>
                            <button type="button" onclick="deleteUser({{$row->userID}})" class="btn btn-primary">Delete</button>
                            
                        </td>
        </tr>
        <?php  } ?>
        </tbody>
        </table>
        {{$res->links()}}
    </div> <!-- /.table-stats -->
</div>
</div>
<script>
    function deleteUser(id)
    {
       x = confirm("Are you sure?")
       if(x==true){
       $.ajax({
    url: '/user/delete',
    type: 'POST',
    data: {userID:id},
    success:function(result){
        debugger;
        location.reload();
    },
    error:function(err){
        console.log(err)
    }
})
}
    }
    function autologon(id)
    {
        location.href='/autologon/'+id;
    }
$('.editUser').click(function() {
    debugger
    $('#mUserId').text($(this).parents('tr').find('.userId').text())
    $('#userID').val($(this).parents('tr').find('.userId').text())
    
    $('#mUserFname').val($(this).parents('tr').find('.userName').text().split(' ')[0])
    $('#mUserLname').val($(this).parents('tr').find('.userName').text().split(' ')[1])
    //$('#mUserBusiness').val($(this).parents('tr').find('.userBusinessCategory').text())
    $('#mUserEmail').val($(this).parents('tr').find('.userEmail').text())
    $('#mUserPhone').val($(this).parents('tr').find('.userPhone').text())
    
    $('#mUserStatus').val($(this).parents('tr').find('.userStatus').text()).prop('selected', true);
    $('#mUserPlan').val($(this).parents('tr').find('.userPlan').text()).prop('selected', true);
    $('#mUserStartDate').val($(this).parents('tr').find('.userDate').text().split(' ')[0])
    $('#mUserEndDate').val($(this).parents('tr').find('.userDate').text().split(' ')[1])
    
})
</script>
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Edit User</strong>
                        </div>
                        <div class="card-body card-block">
                               {!! Form::open(['action'=>'UserController@edit', "method"=>"post","class"=>"form-horizontal"]) !!}
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">UserID</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id="mUserId" class="form-control-static float-left">1234</p>
                                    </div>
                                </div>
                            <input type="text" id="userID" name="id" class="d-none">

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">First
                                            Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserFname" name="fname"
                                            placeholder="Enter First Name" class="form-control"></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Last
                                            Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserLname" name="lname"
                                            placeholder="Enter Last Name" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="email-input"
                                            class=" form-control-label">Email</label></div>
                                    <div class="col-12 col-md-9"><input type="email" id="mUserEmail" name="email"
                                            placeholder="Enter Email" class="form-control"></div>
                                </div> 
                                <div hidden class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Business</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserBusiness" name="business"
                                            placeholder="Enter Business Category" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Phone
                                            No.</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserPhone" name="phoneNo"
                                            placeholder="Enter Phone Number" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="password-input"
                                            class=" form-control-label">Password</label></div>
                                    <div class="col-12 col-md-9"><input type="password" id="mUserPassword"
                                            name="password" placeholder="Password" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select"
                                            class=" form-control-label">Status</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="status" id="mUserStatus" class="form-control">
                                            <option value="0">Please select</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select"
                                            class=" form-control-label">Plan</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="plan" id="mUserPlan" class="form-control">
                                            <option value="0">Please select</option>
                                            <?php foreach($allplans as $plan){ ?>
                                            <option value="{{$plan->PlanTitle}}">{{$plan->PlanTitle}}</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Start
                                            Date</label></div>
                                    <div class="col-12 col-md-9"><input type="date" id="mUserStartDate"
                                            name="startdate" placeholder="Enter Start Date" class="form-control"></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">End
                                            Date</label></div>
                                    <div class="col-12 col-md-9"><input type="date" id="mUserEndDate" name="enddate"
                                            placeholder="Enter End Date" class="form-control"></div>
                                </div>


                            
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="userEditClick" class="btn btn-primary">Confirm</button>
            </div>
    {!! Form::close() !!}
        </div>
</div>
</div>

<div class="modal fade" id="createUser" tabindex="0" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['action'=>'UserController@store', "method"=>"post","class"=>"form-horizontal"]) !!}
                                         
            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Add User</strong>
                        </div>
                           
                        <div class="card-body card-block">
                            
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">First
                                            Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserFname" name="fname"
                                            placeholder="Enter First Name" class="form-control"></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Last
                                            Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserLname" name="lname"
                                            placeholder="Enter Last Name" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="email-input"
                                            class=" form-control-label">Email</label></div>
                                    <div class="col-12 col-md-9"><input type="email" id="usremail" name="email"
                                            placeholder="Enter Email" class="form-control"></div>
                                </div>
                                <div hidden class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Business</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mUserBusiness" name="business"
                                            placeholder="Enter Business Category" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Phone
                                            No.</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="usrphn" value = "+60" name="phone"
                                            placeholder="Enter Phone Number" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="password-input"
                                            class=" form-control-label">Password</label></div>
                                    <div class="col-12 col-md-9"><input type="password" id="mUserPassword"
                                            name="password" placeholder="Password" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select"
                                            class=" form-control-label">Status</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="userStatus" id="mUserStatus" class="form-control">
                                            <option value="0">Please select</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>


                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select"
                                            class=" form-control-label">Plan</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="plan" id="mUserPlan" class="form-control">
                                            <option value="0">Please select</option>
                                            <?php foreach($allplans as $plan){ ?>
                                            <option value="{{$plan->PlanTitle}}">{{$plan->PlanTitle}}</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Start
                                            Date</label></div>
                                    <div class="col-12 col-md-9"><input type="date" id="mUserStartDate"
                                            name="startDate" placeholder="Enter Start Date" class="form-control"></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">End
                                            Date</label></div>
                                    <div class="col-12 col-md-9"><input type="date" id="mUserEndDate" name="endDate"
                                            placeholder="Enter End Date" class="form-control"></div>
                                </div>


                            
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="userEditClick" class="ButtonClicked btn btn-primary">Confirm</button>
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
$('.ButtonClicked').click(function(){
    email = $('#usremail').val();
    phone = $('#usrphn').val();
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
    else if(!email.includes('@') || !email.includes('.'))
    {
        alert('Email is of incorrect format!!');
        return false;
    }
    return true;
})
</script>
@endsection