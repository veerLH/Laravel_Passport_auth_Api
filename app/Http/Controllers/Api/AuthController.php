<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:1',
            'email'=>'required|min:3',
            'password'=>'required|min:3',
            'image'=>'mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
           return response()->json([
            'statusCode' => 500,
            'message'=> 'failed',
            'data'=> $validator->errors(),
           ]);
        }
        $name=$request->name;
        $email=$request->email;
        $password=$request->password;
        $image=$request->image;
        if ($image) {
            $image_name=uniqid().'_'.$image->getClientOriginalName();
            $image->move('/images',$image_name);
        }else{
            $image_name="";
        }
        

        $user=User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>bcrypt($password),
            'image'=>$image_name,
        ]);

        $token=$user->createToken('zinlynn')->accessToken;

        return response()->json([
            'statusCode' => '200',
            'message'=> 'successfully',
            'data'=>$user,
            'token'=>$token
        ]);
    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[           
            'email'=>'required|min:3',
            'password'=>'required|min:6',
            'image'=>'mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
           return response()->json([
            'status' => 500,
            'message'=> 'failed',
            'data'=> $validator->errors(),
           ]);
        }
        $email=$request->email;
        $password=$request->password;

        $login=['email'=>$email,'password'=>$password];
 
      
        if (Auth::attempt($login, false, false)) {
           $user=Auth::user();
        
           $token=$user->createToken('zinlynn')->accessToken;
           return response()->json([
            'statusCode' => '200',
            'message'=> 'successfully',
            'data'=>$user,
            'token'=>$token
        ]);
        }

        return response()->json([
            'status' => '500',
            'message'=> 'failed',
            'data'=>[
                'error'=>'email and Password incorrect'
            ],
           
        ]);
    }

    public function logout(Request $res)
    {
      if (Auth::user()) {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
          'statusCode' => '200',
          'message' => 'Logout successfully'
      ]);
      }else {
        return response()->json([
          'statusCode' => '500',
          'message' => 'Unable to Logout'
        ]);
      }
     }
}
