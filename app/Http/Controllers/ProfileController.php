<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where(['user_id' => $request->user()->id])->get();
        $user = $request->user();
        return view('profiles.profile', compact('posts', 'user'));
    }
}
