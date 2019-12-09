@extends('layouts.app')

@section('content')

  <div class="d-flex justify-center mb-2">
    <a href={{ route('posts.create') }} class="btn btn-success">Add Posts</a>
  </div>
  <div class="card card-default">
    <div class="card-header">Posts</div>
    <div class="card-body">
      <table class="table">
        <thead>
          <th><b>Image</b></th>
          <th><b>Title</b></th>
          <th></th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr>
            <td>
              <img src="{{asset($post->image)}}" width="120px" height="60px" alt="featured_image">
            </td>
            <td><i>{{$post->title}}</i></td>
            <td><button class="btn btn-info btn-sm">Edit</button></td>
            <td><button class="btn btn-danger btn-sm">Trash</button></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection