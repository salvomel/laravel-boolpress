@extends('layouts.dashboard')

@section('content')
    <section>
        <h1>Posts List</h1>

        <div class="row row-cols-3">
            @foreach ($posts as $post)
                
                <div class="col">
                    <div class="card mt-2">
                        @if ($post->cover)
                            <img src="{{ asset('storage/' . $post->cover) }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::substr($post->content, 0, 70) }}...</p>
                            <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-primary">Read Post</a>
                        </div>
                    </div>
                </div>
                
            @endforeach
        </div>

        {{-- Links altre pagine --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </section>
@endsection