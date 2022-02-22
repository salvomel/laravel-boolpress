@extends('layouts.dashboard')

@section('content')
    <section>
        <h1>Posts List</h1>

        <div class="row row-cols-3">
            @foreach ($posts as $post)
                
                <div class="col">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::substr($post->content, 0, 70) }}...</p>
                            <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-success">Leggi il post</a>
                        </div>
                    </div>
                </div>
                
            @endforeach
        </div>
    </section>
@endsection