<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function Search(Request $request)
    {
        // return $request->all();
        $sonod_type = $request->sonod_type;
        $from = $request->from;
        $to = $request->to;
        $union = $request->union;

        if($union){


            if($from && $to){
                return Payment::where(['union'=>$union,'sonod_type'=>$sonod_type,'status'=>'Paid'])->whereBetween('date', [$from, $to])->orderBy('id','desc')->get();
            }elseif($from){
                return Payment::where(['union'=>$union,'sonod_type'=>$sonod_type,'status'=>'Paid'])->where('date',$from)->orderBy('id','desc')->get();
            }else{
                return Payment::where(['union'=>$union,'sonod_type'=>$sonod_type,'status'=>'Paid'])->orderBy('id','desc')->get();
            }
        }else{

            if($from && $to){
                return Payment::where(['sonod_type'=>$sonod_type,'status'=>'Paid'])->whereBetween('date', [$from, $to])->orderBy('id','desc')->get();
            }elseif($from){
                return Payment::where(['sonod_type'=>$sonod_type,'status'=>'Paid'])->where('date',$from)->orderBy('id','desc')->get();
            }else{
                return Payment::where(['sonod_type'=>$sonod_type,'status'=>'Paid'])->orderBy('id','desc')->get();
            }
        }

    }



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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
