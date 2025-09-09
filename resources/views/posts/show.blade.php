@extends('layouts.master')
@section('title', 'Show Post')
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@endsection

@section('content')
    <div class="s-content content">
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

        <main class="row content__page">
            <article class="col-12 entry format-standard">

                @if ($post->image)
                    <div class="media-wrap entry__media text-center mb-3">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="blog-image">
                    </div>
                @endif

                <div class="content__page-header entry__header text-center">
                    <h1 class="entry__title">{{ $post->title }}</h1>
                    <ul class="entry__header-meta list-unstyled">
                        <li class="author">By <a href="#">{{ $post->user->name ?? 'Unknown' }}</a></li>
                        <li class="date">{{ $post->created_at->format('d M Y') }}</li>
                    </ul>
                </div>

                <div class="entry__content mb-4">
                    <p>{{ $post->content }}</p>
                </div>

                <div class="entry__tags text-center mb-4">
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    @endcan
                    @can('update', $post)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this post?')">
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>

                <h3 class="h5">Comments ({{ $post->comments->count() }})</h3>

                <ol class="commentlist list-unstyled">
                    @forelse ($post->comments as $comment)
                        <li class="depth-1 comment media mb-3">
                            <img class="comment__avatar mr-3 rounded-circle"
                                src="{{ asset('images/avatars/user-01.jpg') }}" alt="avatar" width="30"
                                height="30">

                            <div class="media-body comment__content">
                                <div class="comment__info d-flex justify-content-between">
                                    <div>
                                        <strong>{{ $comment->user->name ?? 'unknown' }}</strong>
                                        <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div>
                                        @can('update', $comment)
                                            <button class="btn btn-warning btn-xxs edit-btn" data-id="{{ $comment->id }}"
                                                data-content="{{ $comment->content }}">
                                                Edit
                                            </button>
                                        @endcan
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xxs"
                                                    onclick="return confirm('You will delete comment')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>


                                <div class="comment__text mt-2" id="comment-text-{{ $comment->id }}">
                                    <p>{{ $comment->content }}</p>
                                </div>


                                <form method="POST" action="{{ route('comments.update', $comment->id) }}"
                                    class="edit-form mt-2" id="edit-form-{{ $comment->id }}" style="display:none;">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" class="form-control mb-2" rows="2">{{ $comment->content }}</textarea>
                                    <button type="submit" class="btn btn-success btn-xxs">Save</button>
                                    <button type="button" class="btn btn-secondary btn-xxs cancel-btn"
                                        data-id="{{ $comment->id }}">Cancel</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <p>No comments yet</p>
                    @endforelse
                </ol>

                <div class="comment-respond mt-4">
                    <h4>Add Comment</h4>
                    <form method="post" action="{{ route('comments.store', $post->id) }}" autocomplete="off">
                        @csrf
                        <fieldset>
                            <div class="mb-3">
                                <textarea name="content" class="form-control mb-2" placeholder="Your Message"></textarea>
                                @error('content')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Add Comment</button>
                        </fieldset>
                    </form>
                </div>
            </article>
        </main>
    </div>
@endsection

@section('js')
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('comment-text-' + id).style.display = 'none';
                document.getElementById('edit-form-' + id).style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('comment-text-' + id).style.display = 'block';
                document.getElementById('edit-form-' + id).style.display = 'none';
            });
        });
    </script>
@endsection
