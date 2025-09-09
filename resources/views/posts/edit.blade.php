@extends('layouts.master')
@section('title', 'Edit Post')
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection

@section('content')

    <div class="s-content">

        <div class="row">

            <div class="column large-6 tab-full">

                <h3>Edit Post</h3>

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="sampleInput">Title </label>
                        <input class="full-width" name="title" type="text" placeholder="add small title"
                            id="sampleInput" value="{{ old('title', $post->title) }}">
                        @error('title')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleMessage">Content</label>
                        <textarea class="full-width" name="content" placeholder="Add description" id="exampleMessage">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <br>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Image</label>


                        @if ($post->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="img-thumbnail"
                                    width="150">
                            </div>
                        @endif


                        <input class="form-control" name="image" type="file" id="formFileMultiple">
                        @error('image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <br>

                    <div class="mb-3">
                        <input class="btn btn-primary full-width" type="submit" value="Update">
                    </div>
                </form>

            </div>

        </div> <!-- end row -->

    </div> <!-- end s-content -->

@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
