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
        <thead><th><b>Name</b></th></thead>
        <tbody>
          @foreach ($categories as $category)
              <tr>
                <td>
                  <i>{{ $category->name }}</i>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection