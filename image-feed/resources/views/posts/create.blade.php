@extends('layouts.app')
@section('content')
<div class="col d-flex justify-content-center">
  <div class="card mx-auto text-center">
    <div class="card-header">
      Create Post
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('store_post')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="postTitle">Post Title</label>
          <input type="text" class="form-control" required name="title" id="postTitle" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <input type="file" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection