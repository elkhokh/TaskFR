@extends('layouts.master')
@section('title', 'Show Post')
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .blog-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .entry__header {
            margin-bottom: 2rem;
        }
        .entry__title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
        }
        .entry__header-meta {
            display: flex;
            justify-content: center;
            gap: 1rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .entry__content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        .entry__tags .btn {
            padding: 0.5rem 1.2rem;
            font-size: 0.85rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .entry__tags .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .commentlist {
            margin: 0;
            padding: 0;
        }
        .comment {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        .comment:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .comment__avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        .comment__info {
            font-size: 0.9rem;
        }
        .comment__text {
            font-size: 1rem;
            color: #333;
        }
        .btn-xxs {
            padding: 0.3rem 0.8rem;
            font-size: 0.75rem;
            border-radius: 5px;
        }
        .alert-box {
            border-radius: 8px;
            padding: 1rem;
            position: relative;
        }
        .alert-box__close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        .comment-respond {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .comment-respond textarea {
            resize: vertical;
            min-height: 100px;
        }
        .comment-respond .btn {
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')
    <div class="s-content content py-5">
        @if (session()->has('success'))
            <div class="alert-box alert-box--success hideit mb-4">
                <p>{{ session('success') }}</p>
                <i class="fa fa-times alert-box__close" aria-hidden="true"></i>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert-box alert-box--error hideit mb-4">
                <p>{{ session('error') }}</p>
                <i class="fa fa-times alert-box__close" aria-hidden="true"></i>
            </div>
        @endif

        <main class="row content__page justify-content-center">
            <article class="col-12 col-md-10 col-lg-8 entry format-standard">
                @if ($post->image)
                    <div class="media-wrap entry__media text-center mb-4">
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

                <div class="entry__content mb-5">
                    <p>{{ $post->content }}</p>
                </div>

                <div class="entry__tags text-center mb-5">
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit Post</a>
                    @endcan
                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this post?')">
                                Delete Post
                            </button>
                        </form>
                    @endcan
                </div>

                <h3 class="h5 mb-4">Comments ({{ $post->comments->count() }})</h3>

                <ol class="commentlist">
                    @forelse ($post->comments as $comment)
                        <li class="depth-1 comment media mb-3">
                            <img class="comment__avatar mr-3 rounded-circle"
                                src="{{ asset('images/avatars/user-01.jpg') }}" alt="avatar">
                            <div class="media-body comment__content">
                                <div class="comment__info d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $comment->user->name ?? 'Unknown' }}</strong>
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
                                                    onclick="return confirm('Are you sure you want to delete this comment?')">
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
                                    <textarea name="content" class="form-control mb-2" rows="3">{{ $comment->content }}</textarea>
                                    <button type="submit" class="btn btn-success btn-xxs">Save</button>
                                    <button type="button" class="btn btn-secondary btn-xxs cancel-btn"
                                        data-id="{{ $comment->id }}">Cancel</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <p class="text-muted">No comments yet</p>
                    @endforelse
                </ol>

                <div class="comment-respond mt-5">
                    <h4 class="mb-3">Add a Comment</h4>
                    <form method="POST" action="{{ route('comments.store', $post->id) }}" autocomplete="off">
                        @csrf
                        <fieldset>
                            <div class="mb-3">
                                <textarea name="content" class="form-control mb-2" placeholder="Your Comment" rows="4"></textarea>
                                @error('content')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit Comment</button>
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
                document.getElementById(`comment-text-${id}`).style.display = 'none';
                document.getElementById(`edit-form-${id}`).style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById(`comment-text-${id}`).style.display = 'block';
                document.getElementById(`edit-form-${id}`).style.display = 'none';
            });
        });
    </script>
@endsection
