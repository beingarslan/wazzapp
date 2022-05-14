@extends("dashview")
@section("dashcontent")
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Support Tickets</strong>
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Reply</th>
                        <th>Date Opened</th>
                        <th>Status</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($supportTickets as $row) {
                    ?>
                    <tr>
                        <td class="tkID">{{$row->tkID}}</td>
                        <td class="userID">{{$row->userID}}</td>
                        <td class="subject">{{$row->subject}}</td>
                        <td class="description">{{$row->description}}</td>
                        @if($row->reply == 'Nan')
                        <td class="reply">{{""}}</td>
                        @else
                        <td class="reply">{{$row->reply}}</td>
                        @endif
                        <td class="dateOpened">{{$row->dateOpened}}</td>
                        <td class="status">{{$row->status}}</td>>
                        <td>
                            <button type="button" class="replyClick btn btn-primary mb-1" data-toggle="modal"
                                data-target="#mediumModal">
                                Reply
                            </button>
                            <button type="button" class="deleteClick btn btn-primary mb-1">
                                Delete
                            </button>
                        </td>
                    </tr>
        <?php  } ?>
        </tbody>
        </table>
        {{$supportTickets->links()}}
    </div> <!-- /.table-stats -->
</div>
</div>
<script>
$('.replyClick').click(function() {
    debugger
    $('#messageID').text($(this).parents('tr').find('.tkID').text())
    $('#messageIDbox').val($(this).parents('tr').find('.tkID').text())
    $('#messageSubject').text($(this).parents('tr').find('.subject').text())
    $('#messageContent').text($(this).parents('tr').find('.description').text())
    $('#messageReply').val($(this).parents('tr').find('.reply').text())
    
})
$('.deleteClick').click(function(){
    let result = confirm("Are you sure?");
    if(result==true)
    {
        let data = $(this).parents('tr').find('.tkID').text();
        $.ajax(
            {
               url: '/support/destroy',
               type: 'POST',
               data: {id: data},
               success:function(result)
               {
                    location.reload();
               }
            })
    }

})
</script>

<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="float-left">Reply</strong>
                        </div>
                        <div class="card-body card-block">
                                {!! Form::open(["action"=>"SupportTicketController@reply",'method'=>'POST']) !!}                            
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Message ID</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id = "messageID" class="form-control-static float-left">1234</p>
                                        <input type='text' id='messageIDbox' name='id' class='d-none'>
                                    </div>
                                </div>
                                
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Message Subject</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id="messageSubject" class="form-control-static float-left">1234</p>
                                    </div>
                                    
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Message Content</label></div>
                                    <div class="col-12 col-md-9">
                                        <p id="messageContent" class="form-control-static float-left">1234</p>
                                    </div>
                                </div>
                                                                
                                 <div class="row form-group">
                                    <div class="col col-md-3"> <label  class=" form-control-label">Reply Message</label></div>
                                    <div class="col-12 col-md-9"><textarea id="messageReply" name="message" rows="9" placeholder="Enter Reply Message..." class="form-control"></textarea>
                                    </div>
                                </div>
                            
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        {!! Form::close() !!}
</div>
</div>
</div>
@endsection