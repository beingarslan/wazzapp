<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SupportTicket;
use App\Plan;
class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->status == 'Admin')
        return view("supportdashview",["supportTickets"=>SupportTicket::paginate(10)]);
        else
        {
            $support = SupportTicket::where("userID",'=',Auth::user()->userID)->get();
            return view("UserSide.supportView",['PLAN'=>Plan::find(Auth::user()->planID)->PlanTitle,"supports"=>$support]);
        }
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
        $support = new SupportTicket();
        $support->description =  $request->message;
        $support->subject =  $request->subject;
        $support->userID = Auth::user()->userID;
        $support->dateOpened = date("Y-m-d");
        $support->status = 'Pending';
        $support->save();
        return redirect("/support");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request)
    {
        if(Auth::user()->status!='Admin')
        {
            return "Permission Error!!";
        }
        $ticket = SupportTicket::find($request->id);
        if($request->message==NULL)
        {
            $ticket->reply = 'Nan';
            $ticket->status='Pending';
        }
        else
        {
            $ticket->reply = $request->message;
            $ticket->status='Replied';
        }
        $ticket->save();
        return redirect('/support');
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
    public function destroy(Request $request)
    {
        $ticket = SupportTicket::find($request->id);
        $ticket->delete();
        return true;
    }
}
