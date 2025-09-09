@extends('layouts.master')
@section('title', 'My Posts')
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection
@section('content')

    <div class="s-content">

        @if (session()->has('error'))
            <div class="alert-box alert-box--error hideit">
                <p>{{ session('error') }}</p>
                <i class="fa fa-times alert-box__close" aria-hidden="true"></i>
            </div>
        @endif

        <h2 class="text-center mb-4">My Posts</h2>

        <div class="masonry-wrap">
            <div class="masonry">
                <div class="grid-sizer"></div>

                @forelse ($posts as $post)
                    <article class="masonry__brick entry format-standard animate-this">

                        <div class="entry__thumb">
                            <a href="{{ route('posts.show', $post->id) }}" class="entry__thumb-link">
                                @if ($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                @else
                                    <img src="{{ asset('/') }}images/thumbs/masonry/woodcraft-600.jpg"
                                        alt="Default Image">
                                @endif
                            </a>
                        </div>

                        <div class="entry__text">
                            <div class="entry__header">
                                <h2 class="entry__title">
                                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                </h2>
                                <div class="entry__meta">
                                    <span class="entry__meta-date">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="entry__excerpt">
                                <p>{{ ($post->content) }}</p>
                            </div>
                        </div>

                    </article>
                @empty
                    <p class="text-center">You don’t have any posts yet.</p>
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
