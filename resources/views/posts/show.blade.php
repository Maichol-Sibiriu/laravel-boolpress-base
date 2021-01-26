@extends('layouts.main')

@section('content')
    
    <div class="container text-center">

        <h1>{{ $post->title }}</h1>

        <p>{{ $post->body }}</p>

        <p>Last update: {{ $post->updated_at->diffForHumans() }}</p>
        
        @if ( ! empty($post->path_img) )
            <img width="100" src="{{ asset('storage/' . $post->path_img) }}" alt="{{ $post->title }}">
        @endif
        
        <div class="mt-3">

            <a class="btn btn-primary" href="{{ route('posts.edit', $post->slug) }}">Edit</a>

            <form class="d-inline" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
    
                <input class="btn btn-primary" type="submit" value="delete">
            </form>
        </div>
    </div>
    
@endsection