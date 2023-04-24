<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(12);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['text' => 'required|max:25', 'picture.*' => 'image|required']);
        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->text = $request['text'];
        $post->save();
        if (!is_null($request['picture']))
        {
            for ($i = 0; $i < count($request['picture']); $i++) {
                $picture = $request->file('picture')[$i]->store('pictures/photos', 'public');
                Photo::create(['post_id' => $post->id, 'picture' => $picture]);
            }
        }
        else
        {
            $post->delete();
            return redirect()->route('posts.index')->with('message', 'Post must be with image/s');
        }
        return redirect()->route('posts.index')->with('message', "Post {$post->text} successfully created");

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $follows = Follow::all();
        $post->setRelation('comments', $post->comments()->paginate(6));
        return view('posts.show', compact('post', 'follows'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update-post', $post);
        $request->validate(['text' => 'required', 'picture.*' => 'image|required']);
        $post->user_id = $request->user()->id;
        $post->text = $request['text'];
        for ($i = 0; $i < count($request['picture']); $i++) {
            $picture = $request->file('picture')[$i]->store('pictures/photos', 'public');
            Photo::create(['post_id' => $post->id, 'picture' => $picture]);
        }
        $post->update();
        return redirect()->route('posts.index')->with('message', "Post {$post->text} successfully updated!");
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete-post', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
