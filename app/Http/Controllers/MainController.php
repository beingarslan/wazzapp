<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Plan;


class MainController extends Controller
{
    public function AddCat(Request $request)
    {
        if(Auth::user()->status !='Admin')
        {
            return "Permission Error";
        }
        DB::delete("insert into businesscategory values(?)",[$request->catName]);
    }
    
    public function deleteCat(Request $request)
    {
        if(Auth::user()->status !='Admin')
        {
            return "Permission Error";
        }
        DB::delete("delete from businesscategory where CategoryName = ?",[$request->catName]);
    }

    public function login()
    {
        return view('login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect("\\");
    }
    public function signup()
    {
        return view('signup');
    }
    public function dashboard()
    {
        $authenticatedUser = Auth::user();
        if($authenticatedUser->status == "Admin")
        {
            return view('dashboard');
        }
        else
        {
            $nteams = DB::select('select count(*) as cnt from team where userid = '.Auth::user()->userID);
            $links = DB::select('select count(*) as cnt from links where userid = '.Auth::user()->userID);
            $teams = DB::select('select * from team_member where teamID in(select teamID from team where userid = '.Auth::user()->userID.")");
            $linksClicked = 0;
            foreach($teams as $team)
            {
                $linksClicked = $linksClicked + $team->clicks;
            }           
            return view("UserSide.userDashboard",['PLAN'=>Plan::find(Auth::user()->planID)->PlanTitle,'nteams'=>$nteams[0]->cnt,'links'=>$links[0]->cnt,'linksClicked'=>$linksClicked]);
        }
    }
    public function usersdashview()
    {
        return view('usersdashview');
    }   
    public function broadcastdashview()
   {
       $authenticatedUser = Auth::user();
        if($authenticatedUser->status == "Admin")
        {
            return view('broadcastdashview');
        }
   }
   public function fundloadhistorydashview()
  { 
      $authenticatedUser = Auth::user();
    if($authenticatedUser->status == "Admin")
    {
      return view('fundloadhistorydashview');
    }
  }
    public function autologon($id)
    {
        if(Auth::user()->status=='Admin')
        {
            Auth::logout();
            Auth::loginUsingId($id);
            return redirect('/');
        }
    }
  public function users(){

    $sheroz = User::All();

    $yoyo = Plan::All();

    return view('usersdashview',[
        'res' => $sheroz,
        'allplans' => $yoyo
    ]);    
   // return $sheroz;
  }
    
  public function store(request $request){
      $plan = new Plan();


    $plan->planTitle = request('planTitle');
    $plan->OriginalPrice = 2.0;
    $plan->SalesPrice = 3.0;
    $plan->PlanDescription = "kyaa";

    $plan->save();

    return $plan;
    }
    public function planUpgrade(Request $request)
    {
        if($request->order_id !=NULL)
        {
            if($request->msg=='ok')
            {
               $var =  DB::select("SELECT * from pendingbilling where billcode='".$request->billcode."'");
               $var=$var[0];
               $pl = Plan::find($var->planID);
               DB::statement('INSERT INTO fund_load_history VALUES(NULL,?,?,?,CURDATE(),CURDATE())',[$var->userID,$var->planID,$pl->SalesPrice]);
               DB::statement("DELETE FROM pendingbilling where billcode='".$request->billcode."'");
            }
            return redirect('/dashboard');
        }
        $plan = Plan::find($request->id);
        $some_data = array(
            'userSecretKey'=>'b8kk9qap-rnco-x3si-ijrn-dq1xqja7aj6e',
            'categoryCode'=>'6tmzpy6c',
            'billName'=>$plan->PlanTitle." Plan Upgrade",
            'billDescription'=>'Plan Upgrade for User: '.Auth::user()->userID,
            'billPriceSetting'=>1,
            'billPayorInfo'=>0,
            'billAmount'=>($plan->SalesPrice*100),
            'billReturnUrl'=>'http://app.wazzap.my/upgrade',
            'billCallbackUrl'=>'http://app.wazzap.my/upgrade',
            'billExternalReferenceNo' => 'xxx',
            'billTo'=>Auth::user()->firstname." ".Auth::user()->lastname,
            'billEmail'=>Auth::user()->email,
            'billPhone'=>Auth::user()->phone
          );
        
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');  
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
        
          $result = curl_exec($curl);
          $info = curl_getinfo($curl);  
          curl_close($curl);
          $obj = json_decode($result);
          DB::insert('insert into pendingbilling values (NULL,?, ?, ?)', [Auth::user()->userID, $request->id,$obj[0]->BillCode]);
          return redirect('https://dev.toyyibpay.com/'.$obj[0]->BillCode);
    }
    
}
