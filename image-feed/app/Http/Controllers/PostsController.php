<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $posts = Post::where('status', 'approved')->paginate(config('app.posts_per_page'));
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
        $request->validate(
            [
                'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'title' => 'required'
            ]
        );
        $path = $request->file('image')->store(config('app.pending_images_dir'));
        $image = Image::create([
            'name' =>  basename($path),
        ]);
        $post = Post::create([
            'title' => $request->input('title'),
            'image_id' => $image->id,
            'user_id' => Auth::id()
        ]);
        if ($post) {
            return redirect()->route('user_posts')->with('success', config('app.success_messages.post_submit'));
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
        $posts = Post::where('user_id', Auth::id())->paginate(config('app.posts_per_page'));
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
    public function approveIndex()
    {
        Gate::authorize('approve-post');
        $posts = Post::where('status', 'pending')->paginate(config('app.posts_per_page'));
        return view('posts.approve', ['posts' => $posts]);
    }
    public function approve(Request $request, Post $post)
    {
        Gate::authorize('approve-post');
        $request->validate([
            'decision' => 'required'
        ]);
        $fileName = $post->image->name;
        if ($request->input('decision') == 'approve') {
            Post::where('id', $post->id)->update(
                [
                    'status' => 'approved'
                ]
            );
            Storage::move(config('app.pending_images_dir') . DIRECTORY_SEPARATOR . $fileName, "/public/images/$fileName");
            return redirect(route('approve_post_list'))->with('success', config('app.success_messages.post_approve'));
        } else if ($request->input('decision') == 'reject') {
            $prev_image_id = $post->image->id;
            $defaultImage = Image::where('name', 'default.jpeg')->find(1);
            if (!$defaultImage) {
                $defaultImage = Image::create([
                    'name' => 'default.jpeg'
                ]);
            }
            Post::where('id', $post->id)->update(
                [
                    'status' => 'rejected',
                    'image_id' => $defaultImage->id
                ]
            );
            Image::where('id', $prev_image_id)->delete();
            Storage::delete(config('app.pending_images_dir') . DIRECTORY_SEPARATOR . $fileName);
            return redirect(route('approve_post_list'))->with('success', config('app.success_messages.reject'));
        }
        return back()->withErrors(['one' => 'Expected value not found']);
    }
}
