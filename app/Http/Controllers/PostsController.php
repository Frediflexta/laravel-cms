<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return view('posts.index')->with('posts', $post->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, CreatePostRequest $request)
    {
        $image = $request->image->store('posts');

        $post->create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $image,
        ]);

        session()->flash('success', 'A new post has been created');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content']);

        // check for images and delete old one if it exits
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');

            $post->deleteImage();

            $data['image'] = $image;
        }

        // update attributes
        $post->update($data);

        session()->flash('success', "{$request->name} category has been updated successfully");

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if ($post->trashed()) {
            $post->forceDelete();
            $post->deleteImage();
        } else {
            $post->delete();
        }

        session()->flash('success', "\"{$post->title}\" post has been deleted successfully");

        return redirect(route('posts.index'));
    }

    /**
     * Permanently delete posts from the db.
     */
    public function trashed(Post $post)
    {
        $trashed = $post->onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);
    }

    /**
     * Restore trashed posts.
     *
     * @param mixed $id
     */
    public function restore($id)
    {
        // find the post by it's id
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        // restore it by calling the restore()
        $post->restore();
        //redirect to the index page, displaying the posts with the restores
        return redirect()->back();
    }
}
