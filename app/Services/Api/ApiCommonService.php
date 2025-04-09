<?php

namespace App\Services\Api;
use App\Services\ContactUsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\RatingService;
use App\Services\FileService;
use App\Services\UserService;
use App\Services\TravelService;
use App\Models\User;
use App\Models\Travel;
use App\Models\Question;
use App\Models\Addplace;
use Illuminate\Support\Facades\DB;

class ApiCommonService
{



/**
     * Add Contact Us
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function contactUs(Request $request)
    {
         $input =
        [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,


        
        'messages' => $request->messages,
        ];
         $contact = ContactUsService::create($input);

            if ($contact) {
        return response()->json(
            [
                'status' => true,
                'message' => 'Data Insert successfully',
                'data' => $contact
            ],
            200
              );
            }  else {
        return response()->json(
            [
                'status' => false,
                'message' => 'Data not Inserted',
                'data' =>[],
            ],
            200
         );
            }
    }




    /**
     * Update  Status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function updateStatus(Request $request){
        $validator=Validator::make($request->all(),[
            'status'=>'required',
            ]);
            if($validator->fails()){
            return response()->json([
                'message'=>'Validation fails',
                'error'=>$validator->errors()
            ],400);
             }
             $input=array();

             $input['status']=$request->status;
            $result=User::where('id',auth()->user()->id)->update($input);

            if ($result) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Status Update Successfully'
                        // 'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Status Not Updated',
                        'data' =>[],
                    ],
                    200
                );
            }
    }



     /**
     * Adventure By ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function adventureById(Request $request){
        $header = $request->header('Accept-Language');

        $languge_id=$header=="en-Us"?0:1;

        if($languge_id==0){
        $adventure=DB::table('adventures')
        ->select('*','adventures.id as id','adventures.name_eng as adventure_name','user_intrests.adv_english as avd_intrest','adventures.discription_eng as avd_discription','adventures.highlight_eng as highlights')
        ->join('user_intrests','user_intrests.id','=','adventures.intrest')
        ->where('user_intrests.status','0')
        ->where('adventures.id',$request->adventure_id)->get();
        }
        else{
            $adventure=DB::table('adventures')
        ->select('*','adventures.id as id','adventures.name_fren as adventure_name','user_intrests.adv_french as avd_intrest','adventures.discription_fren as avd_discription','adventures.highlight_fren as highlights')
        ->join('user_intrests','user_intrests.id','=','adventures.intrest')
        ->where('user_intrests.status','0')
        ->where('adventures.id',$request->adventure_id)->get();
        }

        foreach($adventure as $result){
            if(!empty($result->thumbnail)){
            $result->thumbnail=FileService::image_path($result->thumbnail);
            }

            if(!empty($result->slider)){
                $image_aws=[];
                        foreach(json_decode($result->slider,true) as $image){
                        array_push($image_aws,FileService::image_path($image));
                        }
                        $aws_multiple_slider= json_encode($image_aws);
                        $result->slider= $aws_multiple_slider;
                    }

                    if(!empty($result->audio)){
                        $result->audio=FileService::image_path($result->audio);
                        }

                    $result->avgrage=RatingService::get_avg_rating($request->adventure_id)==null?0:RatingService::get_avg_rating($request->adventure_id);
                    $result->total=RatingService::get_total_rating($request->adventure_id);
        }

            if ($adventure) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Data Find Successfully',
                        'data' => $adventure
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Data Not Found',
                        'data' =>[],
                    ],
                    200
                );
            }
    }


/**
     * Place By Adventure
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function placeById(Request $request){
        // $addplace=Addplace::where('adventure_id',$request->adventure_id)->get();
        $header = $request->header('Accept-Language');

        $languge_id=$header=="en-Us"?0:1;
        $addplace='';
        $adventure='';
        $travel='';
        if($languge_id==0){
        $addplace=DB::table('addplaces')
        ->select('*','place_name_eng as place_name','discription_eng as discription')
        ->where('adventure_id',$request->adventure_id)->get();

        foreach($addplace as $result){
                $data=Question::where('travel_id',$request->trip_id)
                ->where('place_id',$result->id)->first();
                if(!empty($data)){
                    $result->completed=1;
                }
                else{
                    $result->completed=0;
                }
        }

        $adventure=DB::table('adventures')
        ->select('*','adventures.name_eng as adventure_name','adventures.discription_eng as discription','adventures.highlight_eng as highlight','user_intrests.adv_english as user_intrest')
        ->join('user_intrests','user_intrests.id','=','adventures.intrest')
        ->where('user_intrests.status','0')
        ->where('adventures.id',$request->adventure_id)->first();

        $travel=Travel::where('id',$request->trip_id)->first();

        }
        else{
            $addplace=DB::table('addplaces')
        ->select('*','place_name_fren as place_name','discription_fren as discription')
        ->where('adventure_id',$request->adventure_id)->get();

        $adventure=DB::table('adventures')
        ->select('*','adventures.name_fren as adventure_name','adventures.discription_fren as discription','adventures.highlight_fren as highlight','user_intrests.adv_french as user_intrest')
        ->join('user_intrests','user_intrests.id','=','adventures.intrest')
        ->where('user_intrests.status','0')
        ->where('adventures.id',$addplace->adventure_id)->first();

        $travel=Travel::where('id',$request->trip_id)->first();
        }


$details['adventureDetail']=$adventure;
$details['placeDetail']=$addplace;
$details['travelDetails']=$travel;

        if ($addplace) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find Successfully',
                    'data' => $details,
                    // 'adventure'=>$adventure,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Found',
                    'data' =>[],
                ],
                200
            );
        }
}




/**
     * Add Travel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function travel(Request $request)
    {
         $input =
        [
        'adventure_id' => $request->adventure_id,
        'user_id' => auth()->user()->id,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        ];
       $data=Travel::where('adventure_id',$request->adventure_id)
            ->where('user_id',auth()->user()->id)
            ->where('running_status',0)
            ->first();

           if($data){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Your Travel is Incompleted',
                    'data'=>$data,
                ],
                200
                  );
           }
         $travel = TravelService::create($input);

            if ($travel) {
        return response()->json(
            [
                'status' => true,
                'message' => 'Data Insert successfully',
                'data' => $travel
            ],
            200
              );
            }  else {
                    return response()->json(
                    [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' =>[],
                    ],
                    200
                    );
                    }
    }



      /**
     * User  Adventures
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function userAdventure(Request $request){
    $header = $request->header('Accept-Language');

    $languge_id=$header=="en-Us"?0:1;

    if($languge_id==0){
        $top_adventure=DB::table('travel')
        ->select('*','travel.id as id','adventures.name_eng as adventure_name','users.name as user_name','user_intrests.adv_english as avd_intrest','adventures.discription_eng as avd_discription','adventures.highlight_eng as highlights')
        ->join('adventures','adventures.id','=','travel.adventure_id')
        ->join('users','users.id','=','travel.user_id')
        ->join('user_intrests','user_intrests.id','=','adventures.intrest')
        ->where('user_intrests.status','0')
        ->where('travel.user_id',auth()->user()->id)->get();
    }
    else{
        $top_adventure=DB::table('travel')
        ->select('*','travel.id as id','adventures.name_fren as adventure_name','users.name as user_name','user_intrests.adv_french as avd_intrest','adventures.discription_fren as avd_discription','adventures.highlight_fren as highlights')
        ->join('adventures','adventures.id','=','travel.adventure_id')
        ->join('users','users.id','=','travel.user_id')
        ->join('user_intrests','user_intrests.id','=','adventures.intrest')
        ->where('user_intrests.status','0')
        ->where('travel.user_id',auth()->user()->id)->get();
        }

    foreach($top_adventure as $result){
        if(!empty($result->thumbnail)){
        $result->thumbnail=FileService::image_path($result->thumbnail);
        }

        if(!empty($result->slider)){
            $image_aws=[];
                    foreach(json_decode($result->slider,true) as $image){
                    array_push($image_aws,FileService::image_path($image));
                    }
                    $aws_multiple_slider= json_encode($image_aws);
                    $result->slider= $aws_multiple_slider;
                }

                if(!empty($result->audio)){
                    $result->audio=FileService::image_path($result->audio);
                    }

    }

        if ($top_adventure) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find Successfully',
                    'data' => $top_adventure
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Found',
                    'data' =>[],
                ],
                200
            );
        }
}



  /**
     * Get Places By Id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function getPlaceByid(Request $request){
        $header = $request->header('Accept-Language');

        $languge_id=$header=="en-Us"?0:1;

        if($languge_id==0){
        $place=DB::table('addplaces')
        ->select('*','place_name_eng as place_name','discription_eng as discription')
        ->where('id',$request->place_id)->get();
        }
        else{
            $place=DB::table('addplaces')
            ->select('*','place_name_fren as place_name','discription_fren as discription')
            ->where('id',$request->place_id)->get();
        }

        foreach($place as $result){
            if(!empty($result->image)){
            $result->image=FileService::image_path($result->image);
            }

            if(!empty($result->audio)){
                $result->audio=FileService::image_path($result->audio);
                }

        }

        if ($place) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find Successfully',
                    'data' => $place
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Found',
                    'data' =>[],
                ],
                200
            );
        }

    }

     /**
     * Delete User Account
     *
     * @param  \Illuminate\Http\Request  $request and $id
     * @return \Illuminate\Http\Response
     */
    public static function deleteAccount(Request $request){
        $result=UserService::delete_user($request);
           if ($result) {
               return response()->json(
                   [
                       'status' => true,
                       'message' => 'Account Deleted Successfully',
                   ],
                   200
               );
           } else {
               return response()->json(
                   [
                       'status' => false,
                       'message' => 'Data Not Deleted',
                       'data' =>[],
                   ],
                   200
               );
           }
   }




}








