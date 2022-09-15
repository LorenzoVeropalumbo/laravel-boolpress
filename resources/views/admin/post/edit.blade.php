@extends('layouts.dashboard')

@section('content')

<h1>Modifica il post</h1>

{{-- Funzione per stampare gli errori in pagina --}}
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
  </ul>
</div>
@endif

<form action="{{ route('admin.post.update',['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method("PUT")
  <div class="custom-form form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">Selezione una imagine</label>
    <input class="form-control" id="image" type="file" name="image">
    @if ($post->cover)
      <img src="{{ asset('storage/' . $post->cover) }}" :alt="$post->title" class="mt-3">   
    @endif
  </div> 
  <div class="custom-form form-group">
    <label for="category_id">Categoria</label>
    <select class="form-select mb-2" id="category_id" name="category_id">   
      <option value="">Nessuna</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>  
      @endforeach
    </select>
  </div>
  <h4 class="d-block">Tags</h4>
  @foreach ($tags as $tag)
    @if ($errors->any())
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="tag-{{$tag->id}}" name="tags[]" {{  in_array($tag->id, old('tags',[])) ? 'checked' : ''}}>
        <label class="form-check-label size-check" for="tag-{{$tag->id}}">{{ $tag->name }}</label>
      </div>    
    @else
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="tag-{{$tag->id}}" name="tags[]" {{ $post->tags->contains($tag) ? 'checked' : ''}}>
        <label class="form-check-label size-check" for="tag-{{$tag->id}}">{{ $tag->name }}</label>
      </div>    
    @endif    
  @endforeach  
  <div class="custom-form form-group">
    <label for="content">Testo</label>
    <textarea class="form-control" id="content" rows="5" name="content">{{ old('content', $post->content) }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection