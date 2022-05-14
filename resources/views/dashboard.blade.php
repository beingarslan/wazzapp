@extends('dashview')
@section('dashcontent')
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-cash"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text">$
                                        <span class="count">
                                            <?php
                                            $sum = DB::select("SELECT SUM(AMOUNT) as amt FROM fund_load_history;");
                                            foreach ($sum as $s) {
                                                echo $s->amt;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="stat-heading">Revenue
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
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text">
                                        <span class="count">
                                            <?php
                                            $count = DB::select("SELECT COUNT(*) as cnt FROM users;");
                                            foreach ($count as $cnt) {
                                                echo $cnt->cnt;
                                            }
                                            ?>
                                        </span></div>
                                    <div class="stat-heading">Total Users</div>
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
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-browser"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text">
                                        <span class="count">
                                            <?php
                                            $count = DB::select("SELECT SUM(CLICKS) as sm FROM team_member;");
                                            foreach ($count as $cnt) {
                                                echo $cnt->sm;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="stat-heading">Total Link Clicks</div>
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
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-cart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count"><span class="count">
                                                <?php
                                                $count = DB::select("SELECT COUNT(*) as cnt FROM fund_load_history;");
                                                foreach ($count as $cnt) {
                                                    echo $cnt->cnt;
                                                }
                                                ?>
                                            </span></span></div>
                                    <div class="stat-heading">Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php 
$count = DB::select("SELECT p.plantitle as title ,COUNT(f.PLANID) as cnt FROM users f RIGHT JOIN plan p ON f.planid = p.planid
group by p.PlanTitle;");
foreach ($count as $cnt)
{
?>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-credit"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text">
                                        <span class="count">
                                            <?php
                                                echo $cnt->cnt;
                                            ?>
                                        </span>
                                    </div>
                                    <div class="stat-heading"><?php echo $cnt->title ?> Subscriptions</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>
        </div>
    </div>
</div>
@endsection