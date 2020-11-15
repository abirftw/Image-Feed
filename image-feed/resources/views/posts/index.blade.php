@extends('layouts.app')
@section('content')
<div class="col d-flex justify-content-center">
  <div class="card mx-auto">
    <div class="card-header">
      Latest Posts
    </div>
    <ul class="list-group list-group-flush">
      @foreach($posts as $post)
      <li class="list-group-item">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"> {{$post->title}} </h5>
            <p class="card-text">{{$post->user->name}} </p>
            <p class="card-text"><small class="text-muted"> {{$post->updated_at}} </small></p>
          </div>
          <img src={{asset("storage/images" . DIRECTORY_SEPARATOR . $post->image->name)}} class=" card-img-bottom img-fluid" alt="">
        </div>
      </li>
      @endforeach
    </ul>
    <div class="card-footer">
      {{ $posts->links() }}
    </div>
  </div>
</div>
@endsection