@extends('layouts.dashboard')

@section('content')
    <section>
        <h1>Categories List</h1>

        <ul class="mt-3">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('admin.category_info', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </section>
@endsection