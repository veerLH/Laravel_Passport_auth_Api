<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Like;
class LikeController extends Controller
{
    //
    public function like()
    {
        $validator=Validator::make(request()->all(),[
          
            'user_id'=>'required',
      
            'feed_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
             'status' => 500,
             'message'=> 'failed',
             'data'=> $validator->errors(),
            ]);
         }
        $user_id=request()->user_id;
        $feed_id=Auth::id();

        if(!$this->isLike($user_id,$feed_id)){
            $like=Like::create([
                'feed_id'=>$feed_id,
                'user_id'=>$user_id,
        
            ]);
            return response()->json([
                'status' =>'200',
                'message'=>' success Like',
                'data' => 'Like'
            ]);
          
        }else{
            return response()->json([
                'status' =>'500',
                'message'=>'already Like',
                'data' => 'already Like'
            ]);
        }
      
    }

    public function isLike($user_id,$feed_id)
    {
        $like=Like::where('user_id',$user_id)->where('feed_id',$feed_id)->count();

         if ($like) {
            return true;
        }

        return false;
    }

    public function dislike(){
        $like_id=request()->like_id;
        $like=Like::where('id',$like_id)->delete();

        return response()->json([
            'status' =>'200',
            'message'=>' success Like',
            'data' => null
        ]);

    }
}
