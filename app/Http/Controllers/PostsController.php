<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Tag;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesExists')->only(['create', 'store']);
    }

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
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, CreatePostRequest $request)
    {
        // dd($request->tags);
        $image = $request->image->store('posts');

        $newPost = $post->create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $image,
            'category_id' => $request->category,
        ]);

        /*
         * check if a tag was added and attach it to the
         * pivot table.
         */
        if ($request->tags) {
            $newPost->tags()->attach($request->tags);
        }

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
        return view('posts.create')->with('post', $post)
            ->with('categories', Category::all())->with('tags', Tag::all());
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
        $data = $request->only(['title', 'description', 'published_at', 'content', 'category_id']);

        // check for images and delete old one if it exits
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');

            $post->deleteImage();

            $data['image'] = $image;
        }

        /*
         * check if there is a tag in the request
         * and sync() it on update
         */
        if ($request->tags) {
            $post->tags()->sync($request->tags);
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
