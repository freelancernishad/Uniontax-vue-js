<?php

namespace App\Http\Controllers;

use App\Models\HoldingBokeya;
use App\Models\Holdingtax;
use Illuminate\Http\Request;

class HoldingBokeyaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $holdingTax_id = $request->holdingTax_id;
        return HoldingBokeya::where(['holdingTax_id'=>$holdingTax_id])->get();
    }

    function holdingTaxPending(Request $request) {

        $union = $request->union;
        $holdingTax = $request->holdingTax;

        return Holdingtax::with('holdingBokeyas','holdingBokeyas.holdingPayments')->where(['holding_no'=>$holdingTax,'unioun'=>$union])->get();

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
     * @param  \App\Models\HoldingBokeya  $holdingBokeya
     * @return \Illuminate\Http\Response
     */
    public function show(HoldingBokeya $holdingBokeya)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HoldingBokeya  $holdingBokeya
     * @return \Illuminate\Http\Response
     */
    public function edit(HoldingBokeya $holdingBokeya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HoldingBokeya  $holdingBokeya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HoldingBokeya $holdingBokeya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HoldingBokeya  $holdingBokeya
     * @return \Illuminate\Http\Response
     */
    public function destroy(HoldingBokeya $holdingBokeya)
    {
        //
    }


    function holdingTaxEdit(Request $request,$id){
        $holdingBokeya = HoldingBokeya::find($id);
        $holdingBokeya->update(['price'=>$request->price]);
        return $holdingBokeya;

    }


}
