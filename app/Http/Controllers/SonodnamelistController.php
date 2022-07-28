<?php

namespace App\Http\Controllers;

use App\Models\Sonod;
use App\Models\Sonodnamelist;
use Illuminate\Http\Request;

class SonodnamelistController extends Controller
{


    public function updatesonodname(Request $request)
    {
        $id = $request->id;


          $data = $request->all();
          if($id){
            $sonodNameList = Sonodnamelist::find($id);
              return $sonodNameList->update($data);
            }else{

                return Sonodnamelist::create($data);
          }

    }
    public function getsonodname(Request $request,$id)
    {
       return Sonodnamelist::find($id);

    }
    public function deletesonodname(Request $request,$id)
    {

        $sonodnamelist =  Sonodnamelist::find($id);
        $sonodnamelist->delete();
        return 'Sonod Name deleted!';


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->data;
        $admin = $request->admin;
        if($admin){

            return Sonodnamelist::with('sonods')->get();
        }

        if($data){
            return Sonodnamelist::where('enname',$data)->first();
        }
        return Sonodnamelist::all();
    }


    public function sonodCount(Request $request)
    {
       $sonodCount = [];
        $sonodnamelist = Sonodnamelist::all();
        foreach ($sonodnamelist as $value) {

            $sonodCount['Pending'][str_replace(" ", "_", $value->enname)] =  Sonod::where(['sonod_name'=>$value->bnname,'stutus'=>'Pending'])->count();

            $sonodCount['Secretary_approved'][str_replace(" ", "_", $value->enname)] =  Sonod::where(['sonod_name'=>$value->bnname,'stutus'=>'Secretary_approved'])->count();
            $sonodCount['approved'][str_replace(" ", "_", $value->enname)] =  Sonod::where(['sonod_name'=>$value->bnname,'stutus'=>'approved'])->count();


            // print_r($value->bnname);
        }
        return $sonodCount;

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
