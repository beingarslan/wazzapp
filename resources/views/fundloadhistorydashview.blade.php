@extends("dashview")
@section("dashcontent")
<?php
$flh = DB::select("SELECT  FROM plan P;");
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Fund Load History</strong>
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($broadcasts as $row) {
                    ?>
                        <tr>
                            <td class="brID">{{$row->brid}}</td>
                            <td class="brTitle">{{$row->title}}</td>
                            <td class="brMessage">{{$row->message}}</td>
                            <td class="brStatus">{{$row->status}}</td>
                            <td class="brDate">{{$row->startTime."-".$row->endTime}}</td>
                            <td>
                                <button type="button" id="editBroadcast" class="btn btn-primary mb-1" data-toggle="modal" data-target="#mediumModal">
                                    Edit
                                </button>
                                <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">

                                            <div class="modal-body">
                                                <p>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong class="float-left">Edit User</strong>
                                                        </div>
                                                        <div class="card-body card-block">
                                                            <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label class=" form-control-label">BroadcastID</label></div>
                                                                    <div class="col-12 col-md-9">
                                                                        <p id="mBroadcastId" class="form-control-static float-left">1234</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Title</label></div>
                                                                    <div class="col-12 col-md-9"><input type="text" id="mBroadcastTitle" name="text-input" placeholder="Enter Title..." class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Message</label></div>
                                                                    <div class="col-12 col-md-9"><textarea name="textarea-input" id="mBroadcastMessage" rows="9" placeholder="Enter Message..." class="form-control"></textarea></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Status</label></div>
                                                                    <div class="col-12 col-md-9">
                                                                        <select name="select" id="mBroadcastStatus" class="form-control">
                                                                            <option value="0">Please select</option>
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>


                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Start Date</label></div>
                                                                    <div class="col-12 col-md-9"><input type="text" id="mBroadcastStartDate" name="text-input" placeholder="Enter Start Date" class="form-control"></div>
                                                                </div>

                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">End Date</label></div>
                                                                    <div class="col-12 col-md-9"><input type="text" id="mBroadcastEndDate" name="text-input" placeholder="Enter End Date" class="form-control"></div>
                                                                </div>


                                                            </form>
                                                        </div>

                                                    </div>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" id="broadcastEditClick" class="btn btn-primary">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>


                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div> <!-- /.table-stats -->
    </div>
</div>
<script>
    $('#editBroadcast').click(function() {
        debugger
        $('#mBroadcastId').text($(this).parents('tr').find('.brID').text())
        $('#mBroadcastTitle').val($(this).parents('tr').find('.brTitle').text())
        $('#mBroadcastMessage').val($(this).parents('tr').find('.brMessage').text())
        $('#mBroadcastStatus').val($(this).parents('tr').find('.brStatus').text()).prop('selected', true);
        $('#mBroadcastStartDate').val($(this).parents('tr').find('.brDate').text().split('-')[0])
        $('#mBroadcastEndDate').val($(this).parents('tr').find('.brDate').text().split('-')[1])
    })
    $('#userEditClick').click(
        function() {
            $.ajax({
                type: "POST",
                url: '/editUser.php',
                data: $(this).serialize()
            })
        })
</script>

@endsection