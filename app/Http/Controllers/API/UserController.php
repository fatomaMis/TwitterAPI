<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
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

    //follow and unfollow users
    
    public function follow(){
    $id = Auth::id();
    $result = User::where('id', '!=', $id)->get();
    //return $result;
    return response()->json(['data' => $result], 200,[],JSON_NUMERIC_CHECK);
	}

	public function followUser(User $user){
    if (!Auth::user()->isFollowing($user_id)){
        Auth::user()->follows()->create([
          'target_id' =>$user_id,
        ]);

        return response()->json(['sucess'=>'sucessfully followed']);
     }else{
        return response()->json(['oops'=>'u already followed ']);
     }
	}

	public function unfollowUser(User $user)
	{
    if (Auth::user()->isFollowing($user->id)) {
        $follow = Auth::user()->follows()->where('target_id', $user->id)->first();
        $follow->delete();

        return response()->json(['success', 'You are no longer friends with '. $user->name]);
    } else {
        return response()->json(['error', 'You are not following this person']);
    }
  }


}

    
}
