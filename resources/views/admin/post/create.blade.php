@extends('layouts.dashboard')

@section('content')

<h1>Crea il tuo post</h1>

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

<form action="{{ route('admin.post.store') }}" method="POST">
  @csrf
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
  </div>
  
  <div class="form-group">
    <label for="category_id">Categoria</label>
    <select class="form-select mb-2" id="category_id" name="category_id">   
      <option value="">Nessuna</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>  
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="content">Testo</label>
    <textarea class="form-control" id="content" rows="5" name="content">{{ old('content') }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection