@extends('layouts.dashboard')

@section('content')
    <section>
        <div class="container">
            <h1>Area protetta</h1>

            <div class="mt-4">
                <h2>Benvenuto {{ $user->name }}</h2>
    
                @if ($userInfo)
                    <div>Telefono: {{ $userInfo->phone }}</div>
                    <div>Indirizzo: {{ $userInfo->address }}</div>
                @endif
            </div>
        </div>
    </section>
@endsection