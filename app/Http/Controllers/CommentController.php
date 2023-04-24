<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['text' => 'required', 'post_id' => 'required']);
        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->post_id = (int)$request['post_id'];
        $comment->text = $request['text'];
        $comment->save();
        return redirect()->route('posts.index')->with('message', "Comment successfully created");
    }


    /**
     * Remove the specified resource from storage.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete-comment', $comment);
        $comment->delete();
        return redirect()->route('posts.index');
    }
}
