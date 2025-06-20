@extends('adminlte::page')

@section('title', 'Create Blog Post')

@section('content_header')
    <h1>Create Blog Post</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <div class="input-group">
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" id="generate-content-btn">
                                <i class="fas fa-magic mr-1"></i> Generate with AI
                            </button>
                        </div>
                    </div>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" class="form-control-file @error('photo') is-invalid @enderror" id="photo">
                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // TinyMCE Initialization
        tinymce.init({
            selector: '#content',
            plugins: 'code table lists image media link',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
            height: 400,
        });

        // AI Content Generation
        const generateBtn = document.getElementById('generate-content-btn');
        const titleInput = document.getElementById('title');

        generateBtn.addEventListener('click', function() {
            const title = titleInput.value;

            if (!title) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter a title first!',
                });
                return;
            }

            // Show loading state
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Generating...';

            fetch("{{ route('admin.blogs.generateContent') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ title: title })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.content) {
                    tinymce.get('content').setContent(data.content);
                    Swal.fire({
                        icon: 'success',
                        title: 'Content Generated!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Generation Failed',
                    text: 'Something went wrong. Please check the console for details.',
                });
            })
            .finally(() => {
                // Restore button state
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-magic mr-1"></i> Generate with AI';
            });
        });
    });
</script>
@stop 