<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class states
{
    const APPROVED = 1;
    const PENDING  = 2;
}
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::where('status', 'approved')->paginate(5); //posts per page
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $path = $request->file('image')->store('private');
        $image = Image::create([
            'name' =>  basename($path),
        ]);
        $post = Post::create([
            'title' => $request->input('title'),
            'image_id' => $image->id,
            'user_id' => Auth::id()
        ]);
        if ($post) {
            return redirect()->route('user_posts')->with('success', 'Post submitted successfully');
        }
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $posts = Post::where('user_id', Auth::id())->paginate(5);
        return view('posts.show', ['posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
    public function approve()
    {
        Gate::authorize('approve-post');
        $posts = Post::where('status', 'pending')->paginate(5);
        return view('posts.approve', ['posts' => $posts]);
    }
}
