@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>Create a New Post</h2>

        {{-- Banner errori --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Form --}}
        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            {{-- Titolo --}}
            <div class="mb-4 mt-4">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>

            {{-- Categorie --}}
            <div class="mb-4">
                <label for="category_id" class="form-label">Category</label>
                <div>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Nessuna</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <h6>Tags</h6>
                @foreach ($tags as $tag)
                    <div class="form-check">
                        <input {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="form-check-input" name="tags[]" type="checkbox" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            {{-- Contenuto --}}
            <div class="mb-4">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-success">Create</button>
          </form>
    </section>
@endsection