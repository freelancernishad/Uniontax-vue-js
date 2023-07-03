<?php

namespace App\Http\Controllers;

use App\Models\TenderFormBuy;
use Illuminate\Http\Request;

class TenderFormBuyController extends Controller
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
       $tender_id = $request->tender_id;
       $name = $request->name;
       $PhoneNumber = $request->PhoneNumber;

       $form_code = mt_rand(1000000, 9999999);

       $datas = [
            'tender_id'=>$tender_id,
            'name'=>$name,
            'PhoneNumber'=>$PhoneNumber,
            'form_code'=>$form_code,
            'status'=>'Unpaid',
       ];
       $tenderformbuy = TenderFormBuy::create($datas);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TenderFormBuy  $tenderFormBuy
     * @return \Illuminate\Http\Response
     */
    public function show(TenderFormBuy $tenderFormBuy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TenderFormBuy  $tenderFormBuy
     * @return \Illuminate\Http\Response
     */
    public function edit(TenderFormBuy $tenderFormBuy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TenderFormBuy  $tenderFormBuy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TenderFormBuy $tenderFormBuy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TenderFormBuy  $tenderFormBuy
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenderFormBuy $tenderFormBuy)
    {
        //
    }
}
