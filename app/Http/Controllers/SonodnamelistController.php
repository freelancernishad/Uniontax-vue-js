<?php

namespace App\Http\Controllers;

use App\Models\Sonodnamelist;
use Illuminate\Http\Request;

class SonodnamelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->data;

        if($data){
            return Sonodnamelist::where('enname',$data)->first();
        }
        return Sonodnamelist::all();
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
     * @param  \App\Models\Sonodnamelist  $sonodnamelist
     * @return \Illuminate\Http\Response
     */
    public function show(Sonodnamelist $sonodnamelist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sonodnamelist  $sonodnamelist
     * @return \Illuminate\Http\Response
     */
    public function edit(Sonodnamelist $sonodnamelist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sonodnamelist  $sonodnamelist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sonodnamelist $sonodnamelist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sonodnamelist  $sonodnamelist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sonodnamelist $sonodnamelist)
    {
        //
    }
}
