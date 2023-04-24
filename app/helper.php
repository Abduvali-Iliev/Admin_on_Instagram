<?php

function isFollow(\App\Models\User $user){
    $authUser = \Illuminate\Support\Facades\Auth::id();
    $isFoll = \App\Models\Follow::where(["profile_id" => $authUser, "user_id" => $user->id])->get();
    if (count($isFoll) == 0) return true;
    return false;
}

function isLike(\App\Models\User $user)
{
    $authUser = \Illuminate\Support\Facades\Auth::id();
    $isLike = \App\Models\Like::where(['profile_id' => $authUser, 'user_id' => $user->id])->get();
    if (count($isLike) == 0) return true;
    return false;
}

function Comment(\App\Models\Post $post)
{
    $authUser = \Illuminate\Support\Facades\Auth::id();
    $currentComment = \App\Models\Comment::where(['user_id' => $authUser, 'post_id' => $post->id]);

}
