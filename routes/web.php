<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Plan;
use App\link;
use App\Team;
use App\TeamMember;
/*"MainController@login"
    IN CASE OF ANY PROBLEM IN THE WEB APPLICATION 
    PLEASE CONTACT THE VENDOR
    WHATSAPP: +923401214884
*/

Route::get('/', function()
{
    
    $x =  explode(".",$_SERVER['HTTP_HOST']);
    $response = DB::select("select count(*) as cnt from links where linkname = '".$x[0]."'");
    if($response[0]->cnt != 0)
    {
         //rotation logic to be added
         if(isset($_GET['linkRedirect']))
        {
                if($_GET['linkRedirect'] == '1')
                {
                    $response = DB::select("select * from links where linkname = '".$x[0]."'");
                    $address = "/openURL?name=Unknown&email=Unknown&phone=Unknown&linkID=".$response[0]->linkID;
                    return redirect($address);
                }
        }
        $response = DB::select("select * from links where linkname = '".$x[0]."'");
        return view('linkOpener',['linkID' => $response[0]->linkID]); 
        //$message = $response[0]->message;
        //$response = DB::select("select * from team_member where teamID = '".$response[0]->teamID."'");
        //return redirect("https://api.whatsapp.com/send?phone=".$response[0]->phoneNumber."&text=".$message);
    }
    else
    {
        if(Auth::check())
        {
            return redirect('/dashboard');
        }
        $var = new MainController();
        return $var->login();
    }
});
Route::any('/openURL', function (Request $request) {
    $link = link::find($request->linkID);
    if($link->teamID==NULL)
    {
        return "No Teams Assigned!! Link unusable!!";
    }
    $user = User::find($link->userID);
    $plan = Plan::find($user->planID);
    $clicks = DB::select("SELECT COUNT(*) as cnt FROM accesshistory WHERE linkID in(SELECT linkID from links WHERE userID = ?)",[$user->userID]);
    $clicks = $clicks[0]->cnt;
    if($clicks >= $plan->clicksAllowed)
    {
        return "Link Click Limit Exceeded!!";
    }
    $linkweightage = DB::select('SELECT * FROM link_team_weightage WHERE Status = 1 and linkID = '.$request->linkID);
    for($i=0;$i<count($linkweightage);$i++)
    {
        if($i==0)
        {
            $linkweightage[$i]->start = 0;
            $linkweightage[$i]->end = $linkweightage[$i]->clickPercentage;
        }
        else
        {
            $linkweightage[$i]->start = $linkweightage[$i-1]->end + 1;
            $linkweightage[$i]->end = $linkweightage[$i-1]->end + $linkweightage[$i]->clickPercentage;
        }
    }
    $flag=true;
    while($flag)
    {
        $randomNumber = rand(0,100);
        foreach($linkweightage as $row)
        {
            if($randomNumber >= $row->start && $randomNumber <= $row->end)
            {
                $x = DB::select('select count(*) as cnt from accesshistory where linkid = ? and memberphone = ?',[$link->linkID,$row->memberPhone]);
                $x = $x[0]->cnt;
                // if($x < $row->AllowedClicks)
                // {
                    $flag=false;
                    DB::insert('INSERT INTO accesshistory VALUES(NULL,?,?,?,?,?,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP());', [$link->linkID,$request->name,$request->phone,$row->memberPhone,$request->email]);
                    DB::update("UPDATE team_member SET clicks = clicks + 1 where phoneNumber = ? ", [$row->memberPhone]);
                    return redirect("https://api.whatsapp.com/send?phone=".$row->memberPhone."&text=".$link->message);
                // }
            }
        }
    }
    return $linkweightage;
});
Route::get('/signup', "MainController@signup");
Route::post('/logout', "MainController@logout");

//************************Admin Side******************************/
Route::get('/dashboard', "MainController@dashboard")->middleware('auth');

Route::resource('user', 'UserController')->middleware('auth');
Route::post('user/edit','UserController@edit')->middleware('auth');
Route::post('user/delete','UserController@destroy')->middleware('auth');

Route::post('user/authenticate','UserController@authenticate');

Route::get('/autologon/{id}','MainController@autologon')->middleware('auth');


Route::resource('broadcast', 'BroadcastController')->middleware('auth');
Route::post('broadcast/edit', 'BroadcastController@edit')->middleware('auth');
Route::post('broadcast/delete', 'BroadcastController@destroy')->middleware('auth');


Route::resource('fundloadhistory', 'FundLoadHistoryController')->middleware('auth');

Route::resource('plan', 'PlanController')->middleware('auth');
Route::post('plan/edit', 'PlanController@edit')->middleware('auth');
Route::post('plan/delete', 'PlanController@destroy')->middleware('auth');

Route::resource('support', 'SupportTicketController')->middleware('auth');
/****************************************************************/
Route::resource('link', 'LinkController')->middleware('auth');
Route::post('link/edit', 'LinkController@edit');
Route::post('/link', 'LinkController@show')->middleware('auth');
Route::post('/link/destroy', 'LinkController@destroy')->middleware('auth');
Route::post('/link/create', 'LinkController@create')->middleware('auth');


Route::post('/getTeam', 'LinkController@getTeamMembers')->middleware('auth');
Route::post('/reply', 'SupportTicketController@reply')->middleware('auth');
Route::post('/support/destroy', 'SupportTicketController@destroy')->middleware('auth');

Route::get('/linkanalytics', 'LinkController@linkanalytics')->middleware('auth');

Route::get('/team', 'TeamController@index')->middleware('auth');
Route::post('/teamMembers', 'TeamMemberController@show')->middleware('auth');
Route::post('/teamMembers/edit', 'TeamMemberController@edit')->middleware('auth');
Route::post('/teamMembers/destroy', 'TeamMemberController@destroy')->middleware('auth');
Route::post('/teamMembers/create', 'TeamMemberController@create')->middleware('auth');
Route::post('/getLinkInfo',"LinkController@historicData");


Route::post('/createUser',"UserController@createUser");


Route::post('/addCat',"MainController@AddCat");
Route::post('/delCat',"MainController@deleteCat");

Route::get('/planUpgrade', function()
{
    return view("UserSide.planUpgrade",['PLAN'=>Plan::find(Auth::user()->planID)->PlanTitle,'plans'=>Plan::paginate(9)]);
})->middleware('auth');
Route::get('/upgrade','MainController@planUpgrade');


/*Route::get('/dashboard/users', "MainController@usersdashview");

Route::get('/dashboard/broadcast', "MainController@broadcastdashview");

Route::get('/dashboard/fundloadhistory  ', "MainController@fundloadhistorydashview");

Route::get('/users', "MainController@users");

Route::post('/update', "PlanController@store");

Route::post('/upload', 'PlanController@store'); */