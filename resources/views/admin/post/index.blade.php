@extends('layouts.dashboard')

@section('content')
<h1 id="index-h1">Lista dei Post</h1>
@if ($deleted === 'yes')
  <div class="alert alert-success" role="alert">
    Post eliminato con successo
  </div>
@endif

<div class="row row-cols-3">
  @foreach ($posts as $post)
  <div class="col">
    <div class="card m-3">
      @if ($post->cover)
        <img class="card-img-top" src="{{asset('storage/' . $post->cover)}}" :alt="$post->title">   
      @endif   
      <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <div class="tags-container">
          @foreach ($tags as $tag)
            <span class="tags {{$post->tags->contains($tag) ? 'tag-set' : ''}}">{{ $tag->name }}</span> 
          @endforeach
          
        </div>
       
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

<div class="ml-3">
  {{ $posts->links() }}
</div>
@endsection