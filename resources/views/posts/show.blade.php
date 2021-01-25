@extends('layouts.main')

@section('content')
    
    <div class="container text-center">
        <h1>{{ $post->title }}</h1>

        <p>{{ $post->body }}</p>

        <p>Last update: {{ $post->updated_at->diffForHumans() }}</p>

        @if ( ! empty($post->path_img) )
            <img src="{{ asset('storage/' . $post->path_img) }}" alt="{{ $post->title }}">
        @endif

    </div>
    
@endsection