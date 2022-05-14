<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Plan;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authenticatedUser = Auth::user();
        if($authenticatedUser->status == "Admin")
        {
            $users = User::where('status','<>','Deleted')->paginate(10);
            $plans = Plan::all();
            return view("usersdashview",['res'=>$users,'allplans'=>$plans]);
        }
        else
        {
            return view("UserSide.userDashboard");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $allUsers = User::all();
        foreach($allUsers as $row)
        {
            if($row->email == $request->email)
            {
                return 'email';
            }
        }
        /* business: "QWE"
email: "khantastic@gmail.com"
fname: "Shehroz"
lname: "Ahmed"
password: "123456"
phone: "+923401214884"
 */   
        $user = new User();
        $user->firstname = $request->fname;
        $user->lastname = $request->lname;
        $user->status = 'User';
        $user->planID = 1;
        $user->dateStart = date("Y-m-d");
        $user->dateEnd = (string)((int)(date("Y"))+1).'-'.date("m").'-'.date("d");
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->businesscategory = $request->business;
        $user->password = Hash::make($request->password);
        $user->remember_token = 'N';
        $user->save(); 
        return 'OK';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $plans = Plan::All();
        $planId = 0;
        foreach($plans as $plan)
        {
            if($plan->PlanTitle == $request->plan)
            {
                $planId = $plan->planID;
                
            }
        }
        $user->firstname = $request->fname;
        $user->lastname = $request->lname;
        $user->status = $request->userStatus;
        $user->planID = $planId;
        $user->dateStart = $request->startDate;
        $user->dateEnd = $request->endDate;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->businesscategory = $request->business;
        $user->password = Hash::make($request->password);
        $user->save(); 
        return redirect("/user");
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
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            if(Auth::user()->status=='Deleted')
            {
                Auth::logout();
                return "<script>alert('Your account has been deleted!!')</script>";
            }
            if(Auth::user()->status != 'Admin')
            {
                $data = DB::select('SELECT CURRENT_DATE() > dateEnd as dateCheck FROM users where userID = ?', [Auth::user()->userID]);
                if($data[0]->dateCheck == '1')
                {
                    DB::select('UPDATE users set planID = 1 WHERE userID = ?', [Auth::user()->userID]);
                }
            }
            if(Auth::user()->status == 'Inactive')
            {
                Auth::logout();
                return "<script>alert('The account has been deactivated!!');location.href='/';</script>";
            }
            return redirect()->intended('/dashboard');
        }
        else
        {
            return "<script>alert('Incorrect username or Password');location.href='/'</script>";
        }
    }
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        $plans = Plan::All();
        $planId = 0;
        foreach($plans as $plan)
        {
            if($plan->PlanTitle == $request->plan)
            {
                $planId = $plan->planID;
                
            }
        }
        $user->firstname = $request->fname;
        $user->lastname = $request->lname;
        $user->status = $request->status;
        $user->planID = $planId;
        $user->dateStart = $request->startdate;
        $user->dateEnd = $request->enddate;
        $user->email = $request->email;
        $user->phone = $request->phoneNo;
        $user->businesscategory = $request->business;
        if($request->password != "")
        {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect("/user");
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
        if(Auth::user()->status=='Admin')
        {
            $usr = User::find($request->userID);
            $usr->status = 'Deleted';
            $usr->save();
            return true;
        }
    }
}
