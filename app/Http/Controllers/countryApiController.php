<?php

namespace App\Http\Controllers;
use lemonpatwari\bangladeshgeocode\Models\Division;
use lemonpatwari\bangladeshgeocode\Models\District;
use lemonpatwari\bangladeshgeocode\Models\Thana;
use lemonpatwari\bangladeshgeocode\Models\Union;
use Illuminate\Http\Request;

class countryApiController extends Controller
{

    public function getdivisions(Request $r)
    {
        $id =  $r->id;

        return Division::all();

    }

    public function getdistrict(Request $r)
    {
        $id =  $r->id;

        return District::where(['division_id'=>$id])->get();

    }

    public function getthana(Request $r)
    {
        $id =  $r->id;
 echo Thana::where('district_id',$id)->get();

    }


    public function getunioun(Request $r)
    {
        $id =  $r->id;
 echo Union::where('thana_id',$id)->get();

    }

    public function gotoUnion(Request $r)
    {
        $name =  $r->input('id');
if($name=='Banglabandha'){
    echo 'http://www.banglabanda.localhost:8000/';

}else if($name=='Bhojoanpur'){
    echo 'http://www.bhojoanpur.localhost:8000/';
}else if($name=='Buraburi'){
    echo 'http://www.buraburi.localhost:8000/';
}else if($name=='Debnagar'){
    echo 'http://www.debnagar.localhost:8000/';
}else if($name=='Salbahan'){
    echo 'http://www.salbahan.localhost:8000/';
}else if($name=='Tentulia'){
    echo 'http://www.tetulia.localhost:8000/';
}else if($name=='Timaihat'){
    echo 'http://www.tirnaihat.localhost:8000/';
}else{
    echo 0;
}

    }
}