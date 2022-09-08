@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col">
    <div class="card m-3" style="width: 50%;">
      <div class="card-content">
        <h5 class="card-title">{{ $post->title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">Slug : {{ $post->slug }}</h6>
        <p class="card-text">{{ $post->content }}</p>
        <p class="card-text">Categoria del post : {{ $post->category ? $post->category->name : 'Nessuna' }}</p>
        <span>Tags : </span> 
        @forelse ($post->tags as $tag)
          <p class="card-text tag-text">{{ $tag->name }}{{ !$loop->last ? ' -' : ''}}</p>  
        @empty
          <p class="card-text tag-text">Nessun tag</p>
        @endforelse
        <p class="card-text">Creato il : {{ $post->created_at->format('l, j F Y')}}</p>
        <p class="card-text">Aggiornato : {{$updated}} {{$time}} fa</p>      
        <div class="links-post">
          <form action="{{ route('admin.post.destroy',['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input class="card-link red" onClick="return confirm('Sei sicuro di voler cancellare?');" type="submit" value="Elimina">
          </form>
          <a href="{{ route('admin.post.edit',['post' => $post->id]) }}" class="card-link">Modifica</a>
        </div>
      </div>
    </div>     
  </div>
</div>
@endsection