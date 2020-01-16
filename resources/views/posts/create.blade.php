@extends('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
      {{isset($post) ? 'Edit Post' : 'Create Post'}}
    </div>
    <div class="card-body">

      @include('partials.error')

      <form action={{isset($post) ? route('posts.update', $post->id) : route('posts.store')}} method="POST" enctype="multipart/form-data">

        @if(isset($post))
          @method('PUT')
        @endif

        @csrf

        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" class="form-control" name="title" value={{isset($post) ? $post->title : ''}}>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" cols="5" rows="2" class="form-control">{{isset($post) ? $post->description : ''}}</textarea>
        </div>

        <div class="form-group">
          <label for="content">Content</label>

          <input id="content" type="hidden" name="content" value="{{isset($post) ? $post->content : ''}}">
          <trix-editor input="content"></trix-editor>
        </div>

        <div class="form-group">
          <label for="published_at">Published At</label>
        <input type="text" id="published_at" class="form-control" name="published_at" value="{{isset($post) ? $post->published_at : ''}}">
        </div>

        <div class="form-group">
          @if (isset($post))
            <img src="{{asset("storage/$post->image")}}" width="200" height="200" alt="featured_image" class="mb-2">
          @endif
        </div>
        <div class="form-group">
          <label for="image">Image</label>
          <input type="file" id="image" class="form-control" name="image" value="">
        </div>

        <div class="form-group">
          <label for="category">Category</label>
          <select name="category" id="category" class="form-control">
            <option value="">Please choose a category</option>
            @foreach($categories as $category)
              <option value={{$category->id}}
               @if(isset($post))
                @if($category->id === $post->category_id)
                  selected
                @endif
               @endif
              >{{$category->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-success">
            {{isset($post) ? 'Update Post' : 'Create Post'}}
          </button>
        </div>

      </form>
    </div>
  </div>

  @endsection

  @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
      // Otherwise, selectors are also supported
      flatpickr("#published_at", {
        enableTime: true
      });
    </script>
  @endsection

  @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  @endsection