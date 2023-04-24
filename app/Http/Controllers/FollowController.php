<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(Request $request)
    {

        if ($request->user()->id === (int)$request['user_id'])
        {
            return redirect()->route('posts.index')->with('message', "You don't subscribe yourself");
        }
        $follow = new Follow();
        $follow->profile_id = $request->user()->id;
        $follow->user_id = (int)$request['user_id'];
        $follow->save();
        return redirect()->route('posts.index')->with('message', "You successfully subscribed {$follow->user->name}");
    }

    public function destroy(Request $request)
    {
        $isFoll = Follow::where(["profile_id" => $request->user()->id, "user_id" => $request['user_id']])->delete();
        return redirect()->route('posts.index')->with('message', "You successfully unsubscribed");
    }
}
