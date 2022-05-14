@extends("dashview")
@section("dashcontent")
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Plan Settings</strong>
            {!! Form::submit("Add Plan", ['class'=>'btn btn-primary mb-1 float-right',"data-toggle"=>"modal","data-target"=>"#createPlan"]) !!}
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plan Title</th>
                        <th>Original Price</th>
                        <th>Sales Price</th>
                        <th>Description</th>
                        <th>Links Allowed</th>
                        <th>Teams Allowed</th>
                        <th>Clicks Allowed</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($plans as $row) {
                    ?>
                    <tr>
                        <td class="planID">{{$row->planID}}</td>
                        <td class="PlanTitle">{{$row->PlanTitle}}</td>
                        <td class="OriginalPrice">{{$row->OriginalPrice}}</td>
                        <td class="SalesPrice">{{$row->SalesPrice}}</td>
                        <td class="PlanDescription">{{$row->PlanDescription}}</td>
                        <td class="linksAllowed">{{$row->linksAllowed}}</td>
                        <td class="teamsAllowed">{{$row->teamsAllowed}}</td>
                        <td class="clicksAllowed">{{$row->clicksAllowed}}</td>
                        <td>
                            <button type="button"  class="editPlan btn btn-primary mb-1" data-toggle="modal"
                                data-target="#mediumModal">
                                Edit
                            </button>
                            
                        <button type="button" class="delPlan btn btn-primary mb-1">
                            Delete
                        </button>
        
        </td>
        </tr>
        <?php  } ?>
        </tbody>
        </table>
        {{$plans->links()}}
    </div> <!-- /.table-stats -->
</div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Business Category Settings</strong>
            {!! Form::submit("Add Business Category", ['class'=>'btn btn-primary mb-1 float-right','id'=>'addCat']) !!}
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                    <tr>
                        <th >Category Name</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($businessCategory as $row) {
                    ?>
                    <tr>
                        <td class='catName'>{{$row->CategoryName}}</td>
                        <td >
                        <button type="button" class="delCat btn btn-primary mb-1">
                                Delete
                            </button>
                        </td>
                    </tr>
        <?php  } ?>
        </tbody>
        </table>
    </div> <!-- /.table-stats -->
</div>
</div>

<script>
    $('.delPlan').click(function(){
        let result = confirm('Are you sure?');
        if(result !=true)
        {
            return;
        }
        $planID = {planID: $(this).parents('tr').find('.planID').text()};
        $.ajax({
                url:'/plan/delete',
                type:'POST',
                data:$planID,
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
    $('#addCat').click(function(){
    let result = prompt("Please enter the name of the Category:","");
    if(result=="")
    {
        return;
    }
    $.ajax({
                url:'/addCat',
                type:'POST',
                data:{catName:result},
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

$('.delCat').click(function(){
    let result = confirm("Are you sure?");
    if(result==false)
    {
        return;
    }
    var dat = $(this).parents('tr').find('.catName').text();
    $.ajax({
                url:'/delCat',
                type:'POST',
                data:{catName:dat},
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
$('.editPlan').click(function() {
    debugger
    $('#mPlanID').text($(this).parents('tr').find('.planID').text())
    $('#id').val($(this).parents('tr').find('.planID').text())
    $('#mPlanTitle').val($(this).parents('tr').find('.PlanTitle').text())
    $('#mOriginalPrice').val($(this).parents('tr').find('.OriginalPrice').text())
    $('#mSalesPrice').val($(this).parents('tr').find('.SalesPrice').text())
    $('#mPlanDescription').val($(this).parents('tr').find('.PlanDescription').text())
    $('#mLinksAllowed').val($(this).parents('tr').find('.linksAllowed').text())
    $('#mTeamsAllowed').val($(this).parents('tr').find('.teamsAllowed').text())
    $('#mClicksAllowed').val($(this).parents('tr').find('.clicksAllowed').text())
    
})
</script>

<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        
            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Edit Plan</strong>
                        </div>
                        <div class="card-body card-block">
                            {!! Form::open(['action'=>'PlanController@edit', "method"=>"post","class"=>"form-horizontal"]) !!}
                                
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Plan ID</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id="mPlanID" class="form-control-static float-left">1234</p>
                                    </div>
                                </div>
                                <input type="text" id='id' name='planid' class='d-none'>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Plan Title</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mPlanTitle" name="plantitle"
                                            placeholder="Plan Title..." class="form-control"></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Original Price</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mOriginalPrice" name="originalprice"
                                            placeholder="Original Price..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Sales Price</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mSalesPrice" name="salesprice"
                                            placeholder="Sales Price..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Plan Description</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mPlanDescription" name="description"
                                            placeholder="Plan Description..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Links Allowed</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mLinksAllowed" name="links"
                                            placeholder="No. of links allowed..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Teams Allowed</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mTeamsAllowed" name="teams"
                                            placeholder="No. of teams allowed..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Clicks Allowed</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mClicksAllowed" name="clicks"
                                            placeholder="No. of clicks allowed..." class="form-control"></div>
                                </div>
                                
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="planEditClick" class="btn btn-primary">Confirm</button>
            </div>
            {!! Form::close() !!}
        </div>
</div>
</div>
</div>

<div class="modal fade" id="createPlan" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        
            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Add Plan</strong>
                        </div>
                        <div class="card-body card-block">
                            {!! Form::open(['action'=>'PlanController@store', "method"=>"post","class"=>"form-horizontal"]) !!}
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Plan Title</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mPlanTitle" name="plantitle"
                                            placeholder="Plan Title..." class="form-control"></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Original Price</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mOriginalPrice" name="originalprice"
                                            placeholder="Original Price..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Sales Price</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mSalesPrice" name="salesprice"
                                            placeholder="Sales Price..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Plan Description</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mPlanDescription" name="description"
                                            placeholder="Plan Description..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Links Allowed</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mLinksAllowed" name="links"
                                            placeholder="No. of links allowed..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Teams Allowed</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mTeamsAllowed" name="teams"
                                            placeholder="No. of teams allowed..." class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Clicks Allowed</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="mClicksAllowed" name="clicks"
                                            placeholder="No. of clicks allowed..." class="form-control"></div>
                                </div>
                                
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="planCreateClick" class="btn btn-primary">Confirm</button>
            </div>
            {!! Form::close() !!}
        </div>
</div>
</div>
</div>
@endsection