@extends('layouts.dashboard')

@section('content')
<div class="row row-cols-4">
  @foreach ($posts as $post)
  <div class="col">
    <div class="card m-3" style="width: 18rem; height: 150px;">
      <div class="card-body">
        <h5 class="card-title pb-3">{{ $post->title }}</h5>
        {{-- <p class="card-text">{{ $post->content }}</p> --}}
        {{-- <a href="#" class="card-link">Modify Post</a> --}}
        <a href="{{ route('admin.post.show',['post' => $post->id]) }}" class="card-link">Info Post</a>
      </div>
    </div>     
  </div>
  @endforeach
</div>
@endsection