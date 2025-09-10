@extends('layouts.master')
@section('title', 'Create Post')

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .s-content {
            padding: 2rem 0;
            max-width: 700px;
            margin: 0 auto;
        }
        .form-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .full-width {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 1rem;
        }
        .full-width:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        textarea.full-width {
            min-height: 150px;
            resize: vertical;
        }
        .btn--primary {
            background-color: #007bff;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn--primary:hover {
            background-color: #0056b3;
        }
        .image-preview {
            margin-top: 1rem;
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
            display: none;
            border-radius: 4px;
        }
        .text-danger {
            font-size: 0.875rem;
        }
        @media (max-width: 576px) {
            .form-container {
                padding: 1.5rem;
            }

        }

        .image-upload-label {
            display: block;
            border: 2px dashed #2b6cb0;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .image-upload-label:hover {
            background: rgba(43, 108, 176, 0.1);
        }
        .image-upload-label i {
            font-size: 3rem;
            color: #2b6cb0;
            margin-bottom: 1rem;
        }
        .image-upload-label p {
            font-size: 1.2rem;
            color: #1a3c6d;
            margin: 0;
        }
        #image_upload {
            display: none;
        }
    </style>

@endsection

@section('content')
    <div class="s-content">
        <div class="form-container">
            <h3 class="mb-4 text-center">Create New Post</h3>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input class="full-width" name="title" type="text" placeholder="Add a short title"
                    id="title" value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="full-width" name="content" placeholder="Add description" id="content">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                                <label class="form-label">الصور (اختياري)</label>
                                <label for="image_upload" class="image-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>انقر هنا لرفع الصور أو اسحبها هنا</p>
                                </label>
                                <input type="file" id="image_upload" name="imge"  accept="image/*">
                                <div id="image-preview" class="d-flex flex-wrap mt-3"></div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                <div class="mb-3 text-center">
                    <input class="btn btn-success p-3 px-5" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>


        document.getElementById('image_upload').addEventListener('change', function(e) {
                                var preview = document.getElementById('image-preview');
                                preview.innerHTML = '';
                                for (var i = 0; i < e.target.files.length; i++) {
                                    var img = document.createElement('img');
                                    img.style.width = '100px';
                                    img.style.margin = '5px';
                                    img.src = URL.createObjectURL(e.target.files[i]);
                                    preview.appendChild(img);
                                }
                            });
    </script>

@endsection
