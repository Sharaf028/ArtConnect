@extends('layouts.app')
@section('title', 'Upload Artwork – ArtConnect')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #66bb6a 0%, #388e3c 100%);">
                <h4 class="mb-0">Upload New Artwork</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('artworks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select category</option>
                            <option value="digital" {{ old('category') == 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="traditional" {{ old('category') == 'traditional' ? 'selected' : '' }}>Traditional</option>
                            <option value="oil" {{ old('category') == 'oil' ? 'selected' : '' }}>Oil</option>
                            <option value="watercolor" {{ old('category') == 'watercolor' ? 'selected' : '' }}>Watercolor</option>
                            <option value="glass painting" {{ old('category') == 'glass painting' ? 'selected' : '' }}>Glass Painting</option>
                            <option value="sketches" {{ old('category') == 'sketches' ? 'selected' : '' }}>Sketches</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Artwork Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 