@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content mb-2">
    <a href={{route('tags.create')}} class="btn btn-success">
      Add Tag
    </a>
  </div>
  <div class="card card-defult">
    <div class="card-header">Tags</div>
    <div class="card-body">
      @if($tags->count() > 0)
        <table class="table">
          <thead>
              <th><b>Name</b></th>
              <th><b>Post count</b></th>
              <th></th>
          </thead>
          <tbody>
            @foreach ($tags as $tag)
                <tr>
                  <td>
                    <i>{{ $tag->name }}</i>
                  </td>
                <td>
                  {{$tag->posts->count()}}
                </td>

                  <td>
                    <a href={{ route('tags.edit', $tag->id) }} class="btn btn-primary btn-sm">Edit</a>
                    <button class="btn-sm btn-warning" onclick="handleDelete({{$tag->id}})">Delete</button>
                  </td>

                </tr>
            @endforeach
          </tbody>
        </table>

        <!-- Modal -->
        <form action="" method="POST" id="deleteTagForm">

          @csrf
          @method('DELETE')

          <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel ">Delete Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p class="text-center text-bold">Are you sure you want to delete this Tag?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No,not now</button>
                    <button type="submit" class="btn btn-danger">Yes please</button>
                  </div>
                </div>
              </div>
            </div>
        </form>

      @else
        <h3 class="text-center">No tags are available</h3>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function handleDelete(id) {
      var deleteForm = document.querySelector('#deleteTagForm')
      deleteForm.action = '/tags/'+id
      $('#deleteModal').modal('show')
    }
  </script>
@endsection