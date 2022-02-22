@extends('layouts.dashboard')

@section('content')
<section>

    <h1>{{ $post->title }}</h1>

    <h5 class="mt-4 mb-4">Slug: {{ $post->slug }}</h5>

    <p>{{ $post->content }}</p>

    

</section>
@endsection