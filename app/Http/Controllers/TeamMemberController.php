<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Plan;
class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userID = Auth::user()->userID;
        $userPlan = Auth::user()->planID;
        $plan = Plan::find($userPlan);
        $teamsAllowed = $plan->teamsAllowed;
        $userTeams = DB::select('SELECT COUNT(*) as cnt FROM team where userID = '.$userID);
        if((int)$userTeams[0]->cnt >= (int)$teamsAllowed)
        {
            return 'TEAMLIMIT';
        }
        else
        {    
            DB::insert("INSERT INTO team VALUES(NULL,'".$userID."')");
            return $userID;
        }
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
        $teamMembers = DB::select('SELECT * FROM team_member where teamID = '.$request->id);
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
        $request = $request['data'];
        if(count($request) <= 0)
        {
            return 'Incorrect Request';
        }
        // $count = 0;
        // foreach($request as $row)
        // {
        //     $result = DB::select("SELECT clicks from team_member where memberName= '".$row['memberName']."' AND phoneNumber = '".$row['memberPhone']."'");
        //     if(count($result)>0)
        //     $request[$count]['clicks'] = $result[0]->clicks;
        //     else
        //     $request[$count]['clicks'] = 0;
        //     $count = $count + 1;
        // }
        $teamID = $request[0]['teamid'];
        DB::statement('DELETE FROM team_member where teamID = '.$teamID);     
        foreach($request as $row)
        {
            if($row['memberName']==NULL && $row['memberPhone']==NULL && $row['memberBank']==NULL && $row['memberAccount']==NULL)
            {
                continue;
            }
            
            DB::statement("INSERT INTO team_member values(".$row['teamid'].",'".$row['memberName']."','".$row['memberPhone']."','Active','".$row['memberClicks']."','".$row['memberBank']."','".$row['memberAccount']."',NULL,CURDATE());");
        }
        return $request;
    }

    /**p
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
        DB::update('UPDATE links SET teamID=NULL where teamID='.$request->id);
        DB::delete('DELETE FROM team_member where teamID = '.$request->id);
        DB::delete('DELETE FROM team where teamID = '.$request->id);
        return true;
        
    }
}
