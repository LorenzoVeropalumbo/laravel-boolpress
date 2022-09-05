@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col">
    <div class="card m-3" style="width: 50%;">
      <div class="card-content">
        <h5 class="card-title">{{ $post->title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">Slug : {{ $post->slug }}</h6>
        <p class="card-text">{{ $post->content }}</p>
        <p class="card-text">Creato il : {{ $post->created_at }}</p>
        <p class="card-text">Aggiornato il : {{ $post->updated_at }}</p>
        <div class="links-post">
          <a href="{{ route('admin.post.show',['post' => $post->id]) }}" class="card-link red">Elimina</a>
          <a href="{{ route('admin.post.show',['post' => $post->id]) }}" class="card-link">Modifica</a>
        </div>
      </div>
    </div>     
  </div>
</div>
@endsection