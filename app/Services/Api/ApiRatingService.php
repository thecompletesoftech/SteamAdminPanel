<?php

namespace App\Services\Api;
use App\Services\RatingService;
use App\Services\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;
use App\Models\Book;

class ApiRatingService
{

     /**
     * Add Rating
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public static function addRating(Request $request)
    {  
      
        $validator=Validator::make($request->all(),[
            'avd_id'=>'required',
         
            'rating'=>'required|numeric|max:5',
            'review'=>'required|min:200',
            'date'=>'required',
               
            ]);
            if($validator->fails()){
            return response()->json([
                'message'=>'Validation fails',
                'error'=>$validator->errors()
            ],400);
             }

        $input = 
        [
        'avd_id' => $request->avd_id,
        'user_id' => auth()->user()->id,
        'rating' => $request->rating,
        'review' => $request->review,
        'date' => $request->date,
        ];
      
        $rating = RatingService::create($input);
        if ($rating) {
        return response()->json(
            [
                'status' => true,
                'message' => 'Data Insert successfully',
                'data' =>$rating,
            ],
            200
                );
             } else {
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
     * List Rating by adventure
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public static function listavdRating(Request $request)
    { 
   
        // $adventure=Rating::where('avd_id',$request->adventure)->get();
        $adventure=DB::table('ratings')
        ->select('*','ratings.id as id','users.name as user_name')
        ->join('users','users.id','=','ratings.user_id')
        ->where('ratings.avd_id',$request->adventure)->get();
        
        foreach($adventure as $result){
            if(!empty($result->profile)){
                $result->profile=FileService::image_path($result->profile);
                }

        }
        
        // $data=[];
        // $data[0]['average']=RatingService::get_avg_review($request->adventure);
        if ($adventure) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' =>$adventure,
                ],
                200
                    );
                 } else {
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
     * Ask Question
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public static function addQuestion(Request $request)
    {  
      
        $validator=Validator::make($request->all(),[
            'travel_id'=>'required',
            'question'=>'required',
            'place_id'=>'required',           
            ]);
            if($validator->fails()){
            return response()->json([
                'message'=>'Validation fails',
                'error'=>$validator->errors()
            ],400);
             }

        $input = 
        [
        'travel_id' => $request->travel_id,
        'question' => $request->question,
        'place_id' => $request->place_id,
        
        ];
      
        $question = QuestionService::create($input);
        if ($question) {
        return response()->json(
            [
                'status' => true,
                'message' => 'Data Insert successfully',
                'data' =>$question,
            ],
            200
                );
             } else {
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
     * List All Books
     * 
     * @return \Illuminate\Http\Response
     */

     public static function listBook(Request $request)
     { 
        
        $header = $request->header('Accept-Language');   
        $languge_id=$header=="en-Us"?0:1;
        if($languge_id==0){
        $list_book=DB::table('books')
        ->select('*','books.id as id','books.name_eng as book_name','books.discription_eng as discription')
        ->orderBy('id', 'desc')
        ->get();
        }
        else{
            $list_book=DB::table('books')
        ->select('*','books.id as id','books.name_fren as book_name','books.discription_fren as discription')
        ->orderBy('id', 'desc')   
        ->get();
        }

        

        foreach($list_book as $result){
            if(!empty($result->thumbnail)){
            $result->thumbnail=FileService::image_path($result->thumbnail);
            }
        }

        if (count($list_book)>0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' =>$list_book,
                ],
                200
                    );
                 } else {
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

     
     


    

    


}





        

    
