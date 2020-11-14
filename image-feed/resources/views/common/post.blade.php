<div class="card">
  <div class="card-body">
    <h5 class="card-title"> {{$post->title}} </h5>
    <p class="card-text">{{$post->user->name}} </p>
    <p class="card-text"><small class="text-muted"> {{$post->updated_at}} </small></p>
  </div>
  <img src="{{asset('storage/hello.png')}}" class="card-img-bottom img-fluid" alt="">
</div>