@extends("dashview")
@section("dashcontent")
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Payment History</strong>
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Plan ID</th>
                        <th>Timestamp</th>
                        <th>Amount</th>       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($flh as $row) {
                    ?>
                    <tr>
                        <td>{{$row->trID}}</td>
                        <td>{{$row->userID}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->planID}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->amount}}</td>
                        
                    </tr>
        <?php  } ?>
        </tbody>
        </table>
        {{$flh->links()}}
    </div>
</div>
</div>
@endsection