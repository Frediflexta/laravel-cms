@extends('layouts.app')

@section('content')

  <div class="d-flex justify-center mb-2">
    <a href={{ route('posts.create') }} class="btn btn-success">Add Posts</a>
  </div>
  <div class="card card-default">
    <div class="card-header">Posts</div>
    <div class="card-body">
      @if ($posts->count() > 0)
        <table class="table">
          <thead>
            <th><b class="card-title">Image</b></th>
            <th><b class="card-title">Title</b></th>
            <th></th>
            <th></th>
          </thead>
          <tbody>
            @foreach ($posts as $post)
              <tr>
                <td>
                  <img src="{{asset("storage/$post->image")}}" width="100" height="100" alt="featured_image">
                </td>
                <td><i>{{$post->title}}</i></td>
                @if (!$post->trashed())
                  <td><button class="btn btn-info btn-sm">Edit</button></td>
                @endif
                <td>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">

                  @method('DELETE')
                  @csrf

                  <button class="btn btn-danger btn-sm" type="submit">
                    {{$post->trashed() ? ' Delete' : 'Trash'}}
                  </button>
                </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
          <h3 class="text-center">No posts are available</h3>
      @endif
    </div>
  </div>

@endsection