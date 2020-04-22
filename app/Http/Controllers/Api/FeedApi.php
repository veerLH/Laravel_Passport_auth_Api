<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Feed;
use App\Comment;
use Illuminate\Support\Facades\Validator;

class FeedApi extends Controller
{
    
    public function feed()
    {
        $feed=Feed::orderBy('id','DESC')->with('user')->paginate(10);
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $feed
        ]);
    }


    public function create(Request $request)
    {
        $validator=Validator::make($request->all(),[
          
            'description'=>'required|min:3',
      
            'image'=>'mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
            return response()->json([
             'status' => 500,
             'message'=> 'failed',
             'data'=> $validator->errors(),
            ]);
         }
        $image=$request->image;
      
        if ($image) {
            $image_name=uniqid().'_'.$image->getClientOriginalName();
            $image->move(public_path('/feeds'),$image_name);
        }else{
            $image_name="";
        }
        
        $feed=Feed::create([
            'user_id'=>Auth::user()->id,
            'image'=> $image_name,
            'description'=>$request->description
        ]);

        return response()->json([
            'status'=>200,
            'message'=>'succefully',
            'data'=>$feed
        ]);
    }

    public function delete(Feed $feed)
    {
        if(isset($feed)){
            $feed->delete();
            return response()->json([
                'status' => 200,
                'message' => 'delete success',
                'data' => $feed
            ]);
        }
    }

    public function createcomment()
    {
        $validator=Validator::make(request()->all(),[
          
            'feed_id'=>'required',
      
            'comments'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
             'status' => 500,
             'message'=> 'failed',
             'data'=> $validator->errors(),
            ]);
         }
        $user_id=Auth::user()->id;
        $feed_id=request()->feed_id;
        $comments=request()->comments;

        $comment=Comment::create([
            'user_id'=>$user_id,
            'feed_id'=>$feed_id,
            'comments'=>$comments
        ]);

        return response()->json([
            'status' =>'200',
            'message'=>'comment create',
            'data' => $comment
        ]);
    }

    public function getcomment()
    {
        $validator=Validator::make(request()->all(),[
          
            'feed_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
             'status' => 500,
             'message'=> 'failed',
             'data'=> $validator->errors(),
            ]);
         }
        
        $comments=Comment::where('feed_id',request()->feed_id)->with('user')->paginate(10);
       
        return response()->json([
            'status' => '200',
            'message' => 'success',
            'data' =>$comments
        ]);
    }

    public function deletecomment()
    {
        
        $validator=Validator::make(request()->all(),[
          
            'comment_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
             'status' => 500,
             'message'=> 'failed',
             'data'=> $validator->errors(),
            ]);
         }
         $comments=Comment::where('id',request()->comment_id)->delete();
       
        return response()->json([
            'status' => '200',
            'message' => 'success',
            'data' =>$comments
        ]);
    }
}
