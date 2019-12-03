@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content mb-2">
    <a href={{route('categories.create')}} class="btn btn-success">
      Add Category
    </a>
  </div>
  <div class="card card-defult">
    <div class="card-header">Categories</div>
    <div class="card-body">
      <table class="table">
        <thead>
            <th><b>Name</b></th>
            <th></th>
        </thead>
        <tbody>
          @foreach ($categories as $category)
              <tr>
                <td>
                  <i>{{ $category->name }}</i>
                </td>
                <td>
                  <a href={{ route('categories.edit', $category->id) }} class="btn btn-primary btn-sm">Edit</a>
                  <button class="btn-sm btn-warning" onclick="handleDelete({{$category->id}})">Delete</button>
                </td>

              </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Modal -->
      <form action="" method="POST" id="deleteCategoryForm">

        @csrf
        @method('DELETE')

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel ">Delete Category</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-center text-bold">Are you sure you want to delete this category?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">No,not now</button>
                  <button type="submit" class="btn btn-danger">Yes please</button>
                </div>
              </div>
            </div>
          </div>
      </form>

    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function handleDelete(id) {
      var deleteForm = document.querySelector('#deleteCategoryForm')
      deleteForm.action = '/categories/'+id
      $('#deleteModal').modal('show')
    }
  </script>
@endsection