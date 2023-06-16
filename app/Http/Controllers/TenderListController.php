<?php

namespace App\Http\Controllers;

use App\Models\TenderList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TenderListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $union_name = $request->union_name;
        if($union_name){
            return TenderList::where('union_name',$union_name)->orderBy('id','desc')->get();
        }
        return TenderList::orderBy('id','desc')->get();
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
        $datas = $request->all();
        $random = Str::random(60);
        $datas['tender_id'] = time().$random;

        return TenderList::create($datas);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function show(TenderList $tenderList,$id)
    {
        return TenderList::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function edit(TenderList $tenderList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TenderList $tenderList,$id)
    {
        $datas = $request->all();

        $tenderList = TenderList::find($id);

        $tenderList->update($datas);

         return $tenderList;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenderList $tenderList)
    {
       $tenderList->delete();
       return 1;
    }
}
