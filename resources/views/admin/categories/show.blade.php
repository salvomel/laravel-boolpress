@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>{{ $category->name }}</h2>

        <ul class="mt-3">
            @forelse ($posts as $post)
                <li>
                    <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                </li>
            @empty
                <div>No Posts found</div>
            @endforelse
        </ul>
    </section>
@endsection