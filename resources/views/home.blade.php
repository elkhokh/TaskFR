@extends('layouts.master')
@section('title', 'Home')
@section('css')

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection
@section('content')

<div class="s-content">
@if (session()->has('success'))
    <div class="alert-box alert-box--success hideit">
        <p>{{ session('success') }}</p>
        <i class="fa fa-times alert-box__close" aria-hidden="true"></i>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert-box alert-box--error hideit">
        <p>{{ session('error') }}</p>
        <i class="fa fa-times alert-box__close" aria-hidden="true"></i>
    </div>
@endif


<div class="masonry-wrap">
    <div class="masonry">
        <div class="grid-sizer"></div>

        @forelse ($posts as $post)
            <article class="masonry__brick entry format-standard animate-this">

                <div class="entry__thumb">
                    <a href="{{ route('posts.show', $post->id) }}" class="entry__thumb-link">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        @else
                            <img src="{{ asset('/') }}images/thumbs/masonry/woodcraft-600.jpg" alt="Default Image">
                        @endif
                    </a>
                </div>

                <div class="entry__text">
                    <div class="entry__header">
                        <h2 class="entry__title">
                            <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                        </h2>
                        <div class="entry__meta">
                            <span class="entry__meta-cat">
                                <a href="#">{{ $post->user->name }}</a>
                            </span>
                            <span class="entry__meta-date">
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="entry__excerpt">
                        <p>{{ Str::limit($post->content, 150) }}</p>
                    </div>
                </div>

            </article>
        @empty
            <p class="text-center">No Posts Found.</p>
        @endforelse

    </div> <!-- end masonry -->
</div> <!-- end masonry-wrap -->

<div class="row">
    <div class="column large-full text-center">
        {{ $posts->links() }}
    </div>
</div>


    </div> <!-- end s-content -->
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
