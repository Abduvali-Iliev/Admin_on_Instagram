<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['post_id' => 'required']);
        $like = new Like();
        $like->profile_id = $request->user()->id;
        $like->user_id = (int)$request['user_id'];
        $like->post_id = (int)$request['post_id'];
        $like->save();
        return redirect()->route('posts.index');
    }

    public function destroy(Request $request)
    {
        $isLike = Like::where(
                    [   'profile_id' => $request->user()->id,
                        'user_id' => $request['user_id']
                        ])->delete();
        return redirect()->route('posts.index');
    }
}
