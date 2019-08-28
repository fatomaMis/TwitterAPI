<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User; 
use Auth;
// use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorized'], 401); 
        } 
    }


	/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
	return response()->json(['success'=>$success], $this-> successStatus); 
    }


    /** 
     * Follow and Unfollow action api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
     public function action($id, Request $request)
{
	$user = User::where('id', $id)->first();
	$token = Auth::user();

    switch ($request->get('act')) {
        case "follow":
            $user->following()->attach($token->$id);
            return response()->json(['success', 'You are no longer friends with '. $token->name]);
            break;
        case "unfollow":
            $user->following()->detach($token->$id);
            return response()->json(['error', 'You are not following this person']);
            break;
        default:
        	return response()->json(['error', 'wrong action']);
    }
}


  public function getTweets(){
  	$user = User::with('followers.tweets')->find(1); 
  	$user->tweets();
  }

   
}
