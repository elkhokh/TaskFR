@extends('layouts.master')
@section('title', 'CreatePOst')
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection
@section('content')

    <div class="s-content">

        <div class="row">

            <div class="column large-6 tab-full">

                <h3>Add Post</h3>

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="sampleInput">Title </label>
                        <input class="full-width" name="title" type="text" placeholder="add small title"
                            id="sampleInput" value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="exampleMessage">Content</label>
                        <textarea class="full-width" name="content" placeholder="Add description" id="exampleMessage">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <br>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Image</label>
                        <input class="form-control" name="image" type="file" id="formFileMultiple">
                        @error('image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <br>
                    <br>

                    <div class="mb-3">
                        <input class="btn--primary full-width" type="submit" value="Submit">
                    </div>
                </form>

            </div>

        </div> <!-- end s-content -->

    @endsection

    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
