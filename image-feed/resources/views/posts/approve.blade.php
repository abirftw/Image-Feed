@extends('layouts.app')
@section('content')
<div class="col d-flex justify-content-cente">
  <div class="card mx-auto">
    <div class="card-header">
      Pending Posts
    </div>
    <ul class="list-group list-group-flush">
      @foreach($posts as $post)
      <form method="POST" action="{{route('approve_post', [$post->id])}}">
        @csrf
        <li class="list-group-item">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> {{$post->title}} </h5>
              <p class="card-text">{{$post->user->name}} </p>
              <p class="card-text"><small class="text-muted"> {{$post->updated_at}} </small></p>
            </div>
            <img src="{{route('get_image', [$post->image->name])}}" class="card-img-bottom img-fluid" alt="{{$post->title}}">
          </div>
          <div class="card-footer">
            <button type="submit" name="decision" value="reject" class="btn btn-danger">Reject</button>
            <button type="submit" name="decision" value="approve" class="btn btn-success">Approve</button>
          </div>
        </li>
      </form>
      @endforeach
    </ul>
  </div>
</div>
{{ $posts->links() }}
@endsection