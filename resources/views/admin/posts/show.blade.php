@extends('layouts.dashboard')

@section('content')
<section>
    
    <h1>{{ $post->title }}</h1>

    <h5 class="mt-4 mb-2 ">Created: {{ $post->created_at->format('j F Y - H:i') }}</h5>
    <h5 class="mb-4 ">Updated: {{ $post->updated_at->diffForHumans() }}</h5>

    <h5 class="mt-4 mb-2">Slug: {{ $post->slug }}</h5>

    <h5 class="mb-2">Category: {{ $post->category ? $post->category->name : 'nessuna' }}</h5>

    <h5 class="mb-4">Tags:
        @forelse ($post->tags as $tag)
            {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
        @empty
            nessuno
        @endforelse
    </h5>

    {{-- Immagine --}}
    @if ($post->cover)
        <div>
            <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}">
        </div>
    @endif
    
    <p>{{ $post->content }}</p>

    {{-- Buttons --}}
    <div class="d-flex mt-4">

        <div class="mr-2">
            <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" class="btn btn-warning">Edit Post</a>
        </div>
    
        <div>
            <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')
    
                <button class="btn btn-danger">Delete Post</button>
            </form>
        </div>
    </div>

</section>
@endsection