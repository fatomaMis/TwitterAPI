<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\TweetResource;
use App\Tweet;
use Auth;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweet = Tweet::all();
        return TweetResource::collection($tweet);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tweet_text = $request->input('tweet_text');
        $user = Auth::user();
        // dd($user);
        $tweet = new Tweet;

        $tweet->tweet_text =$tweet_text;
        $tweet->user_id = $user->id;
        $tweet->user_screen_name = $user->name;

        $tweet->save();
        return new TweetResource($tweet);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $article = Tweet::find($id); //id comes from route
        if( $article ){
            return new TweetResource($article);
        }
        return "Tweet Not found"; // temporary error
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::findOrfail($id);
        if($tweet->delete()){
            return  new TweetResource($tweet);
        }
        return "Error while deleting";
    }
}
