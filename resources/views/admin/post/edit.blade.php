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

<form action="{{ route('admin.post.update',['post' => $post->id]) }}" method="POST">
  @csrf
  @method("PUT")
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
  </div>
  <div class="form-group">
    <label for="content">Testo</label>
    <textarea class="form-control" id="content" rows="5" name="content">{{ old('content', $post->content) }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection