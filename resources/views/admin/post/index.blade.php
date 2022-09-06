@extends('layouts.dashboard')

@section('content')
<h1>Lista dei Post</h1>
@if ($deleted['deleted'] === 'yes')
<div class="alert alert-success" role="alert">
  Post eliminato con successo
</div>
@endif
<div class="row row-cols-4">
  @foreach ($posts as $post)
  <div class="col">
    <div class="card m-3" style="width: 18rem; height: 150px;">
      <div class="card-body">
        <h5 class="card-title pb-3">{{ $post->title }}</h5>
        {{-- <p class="card-text">{{ $post->content }}</p> --}}
        {{-- <a href="#" class="card-link">Modify Post</a> --}}
        <div class="links-post">
          <a href="{{ route('admin.post.show',['post' => $post->id]) }}" class="card-link blue">Informazioni</a>
          <form action="{{ route('admin.post.destroy',['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input class="card-link red" onClick="return confirm('Sei sicuro di voler cancellare?');" type="submit" value="Elimina" >
          </form>
          <a href="{{ route('admin.post.edit',['post' => $post->id]) }}" class="card-link blue">Modifica</a>
        </div>
      </div>
    </div>     
  </div>
  @endforeach
</div>
@endsection