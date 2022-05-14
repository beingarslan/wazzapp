<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->status == "Admin")
        {
            $broadcasts = Broadcast::all();
            return view("broadcastdashview",['broadcasts'=>$broadcasts]);
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
        $broadcast = new Broadcast();
        $broadcast->title = $request->title;
        $broadcast->message = $request->message;
        $broadcast->status = $request->status;
        $broadcast->startTime = $request->startdate;
        $broadcast->endTime = $request->enddate;
        $broadcast->save();
        return redirect("/broadcast");
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
        $broadcast = Broadcast::find($request->id);
        $broadcast->title = $request->title;
        $broadcast->message = $request->message;
        $broadcast->status = $request->status;
        $broadcast->startTime = $request->startdate;
        $broadcast->endTime = $request->enddate;
        $broadcast->save();
        return redirect("/broadcast");
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
            $brd = Broadcast::find($request->brid);
            $brd->delete();
            return true;
        }
    }
}
