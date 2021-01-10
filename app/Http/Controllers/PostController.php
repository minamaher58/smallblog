<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        // $posts = Post::get();  // Collection
        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->simplePaginate(25);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // Post::create({
        //     'user_id' => auth()->user()->id(),
        //     'body' => $request->body
        // });

        // auth()->user()->posts()->create();

        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]);

        $request->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }
}
