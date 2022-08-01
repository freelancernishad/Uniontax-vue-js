<?php

namespace App\Http\Controllers;

use App\Models\Uniouninfo;
use Illuminate\Http\Request;

class UniouninfoController extends Controller
{


        public function contact(Request $request)
        {

            $Uniouninfo =  Uniouninfo::where(['short_name_e'=>$request->union])->first();

            // return $request->all();

            $details = [
                'title' => "Mail from Name: $request->name Email: <a href='mailto:$request->email'>$request->email</a>",
                'body' => "$request->message"
            ];

            \Mail::to("$Uniouninfo->contact_email")->send(new \App\Mail\MyTestMail($details));

            // dd("Email is Sent.");

        }

        public function unionInfo(Request $request)
        {
            // return $request->all();
          $uniouninfo =   Uniouninfo::where(['short_name_e'=>$request->union])->first();

          $Insertdata = $uniouninfo;
          $Insertdata['c_signture'] =  asset($uniouninfo->c_signture);
            $Insertdata['sonod_logo'] =  asset($uniouninfo->sonod_logo);
            $Insertdata['u_image'] =  asset($uniouninfo->u_image);
            $Insertdata['web_logo'] =  asset($uniouninfo->web_logo);
return $Insertdata;
        }


        public function unionInfoUpdate(Request $request)
        {
            $id = $request->id;

            $Insertdata = $request->except(['c_signture','sonod_logo','u_image','web_logo']);

            $c_signtureCount =  count(explode(';',$request->c_signture));
            $sonod_logoCount =  count(explode(';',$request->sonod_logo));
            $u_imageCount =  count(explode(';',$request->u_image));
            $web_logoCount =  count(explode(';',$request->web_logo));

            if($c_signtureCount>1){
                $Insertdata['c_signture'] =  fileupload($request->c_signture,"unioninfo/c_signture/");
            }
            if($sonod_logoCount>1){
                $Insertdata['sonod_logo'] =  fileupload($request->sonod_logo,"unioninfo/sonod_logo/");
            }
            if($u_imageCount>1){
                $Insertdata['u_image'] =  fileupload($request->u_image,"unioninfo/u_image/");
            }
            if($web_logoCount>1){
                $Insertdata['web_logo'] =  fileupload($request->web_logo,"unioninfo/web_logo/");
            }


            $uniouninfo =  Uniouninfo::find($id);
            $uniouninfo->update($Insertdata);
            return $request->all();
        //   return   Uniouninfo::where(['short_name_e'=>$request->union])->first();
        }
        public function paymentUpdate(Request $request)
        {
            $paymentType =  $request->paymentType;
            $district =  $request->district;
             $unions =  Uniouninfo::where('district',$district)->get();

            foreach ($unions as $value) {
                // return $value->id;
               $singleunion = Uniouninfo::find($value->id);
               $singleunion->update(['payment_type'=>$paymentType]);
            }
            return 'Payment Type Updated';

        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $position =$request->position;
         $thana = $request->thana;
         $district = $request->district;

        if ($position && $thana && $district) {


            if($position=='District_admin'){
                return Uniouninfo::where('district', $district)->get();



            }else
            if($position=='Thana_admin'){
                return Uniouninfo::where(['district'=> $district,'thana'=> $thana])->get();

            }else{
                return '';
            }


        }
        return Uniouninfo::all();
    }
    public function getunion(Request $request, $id)
    {
            // return $request->all();
            $uniouninfo =   Uniouninfo::find($id);

            $data = $uniouninfo;
            $data['c_signture'] =  asset($uniouninfo->c_signture);
              $data['sonod_logo'] =  asset($uniouninfo->sonod_logo);
              $data['u_image'] =  asset($uniouninfo->u_image);
              $data['web_logo'] =  asset($uniouninfo->web_logo);
  return $data;
    }
    public function deleteunion(Request $request, $id)
    {
        $sonodnamelist =  Uniouninfo::find($id);
        $sonodnamelist->delete();
        return 'Union deleted!';
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
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return \Illuminate\Http\Response
     */
    public function show(Uniouninfo $uniouninfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return \Illuminate\Http\Response
     */
    public function edit(Uniouninfo $uniouninfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uniouninfo $uniouninfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Uniouninfo  $uniouninfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uniouninfo $uniouninfo)
    {
        //
    }
}
