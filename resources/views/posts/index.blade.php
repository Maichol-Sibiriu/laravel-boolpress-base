@extends('layouts.main')

@section('content')
    
    <div class="container text-center">
        <h1>BLOGPAGE</h1>

        @if (session('post-deleted'))
            <div class="alert alert-success">
                Post '{{ session('post-deleted') }}' has been deleted successfully.
            </div>
        @endif

        @forelse ($posts as $post)
            <div class="mb-10">
                <h2>{{ $post->title }}</h2>
                <p class="mb-5">{{ $post->created_at->format('d/m/Y') }}</p>
                <p>{{ $post->body }}</p>
                <a href="{{ route('posts.show', $post->slug) }}">SHOW</a>
            </div>
        @empty
            <h2>NO POST FOUND</h2>
            <a href="{{ route('posts.create') }}">Create New Post</a>
        @endforelse

        {{ $posts->links() }}
    </div>
    
@endsection