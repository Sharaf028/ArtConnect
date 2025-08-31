@extends('layouts.app')
@section('title', 'Request Commission - ' . $artist->name . ' - ArtConnect')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('artists.show', $artist) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0">Request Commission</h1>
            </div>

            <!-- Artist Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body bg-light">
                    <div class="d-flex align-items-center">
                        <img src="{{ $artist->profile_picture_url }}" alt="{{ $artist->name }}" 
                             class="rounded-circle me-3" width="64" height="64" style="object-fit: cover;"
                             onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCAxMjAgMTIwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8Y2lyY2xlIGN4PSI2MCIgY3k9IjYwIiByPSI2MCIgZmlsbD0iIzI4QTc3QSIvPgo8c3ZnIHg9IjI4IiB5PSIyOCIgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9IndoaXRlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cGF0aCBkPSJNMTIgMTJjMi4yMSAwIDQtMS43OSA0LTRzLTEuNzktNC00LTQtNCAxLjc5LTQgNCAxLjc5IDQgNCA0em0wIDJjLTIuNjcgMC04IDEuMzQtOCA0djJoMTZ2LTJjMC0yLjY2LTUuMzMtNC04LTR6Ii8+Cjwvc3ZnPgo8L2NpcmNsZT4K'">
                        <div>
                            <h4 class="mb-1">{{ $artist->name }}</h4>
                            <p class="text-muted mb-2">{{ $artist->bio ?: 'Professional Artist' }}</p>
                            @if($artist->role === 'artist' && $artist->is_available)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Available for new work
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Commission Request Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-handshake me-2"></i>Commission Request Form</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('commissions.store', $artist) }}">
                        @csrf
                        
                        <!-- Work Type -->
                        <div class="mb-3">
                            <label for="work_type" class="form-label">Type of Work <span class="text-danger">*</span></label>
                            <select id="work_type" name="work_type" class="form-select" required>
                                <option value="">Select work type...</option>
                                <option value="portrait" {{ old('work_type') == 'portrait' ? 'selected' : '' }}>Portrait</option>
                                <option value="landscape" {{ old('work_type') == 'landscape' ? 'selected' : '' }}>Landscape</option>
                                <option value="character_design" {{ old('work_type') == 'character_design' ? 'selected' : '' }}>Character Design</option>
                                <option value="illustration" {{ old('work_type') == 'illustration' ? 'selected' : '' }}>Illustration</option>
                                <option value="digital_art" {{ old('work_type') == 'digital_art' ? 'selected' : '' }}>Digital Art</option>
                                <option value="traditional_art" {{ old('work_type') == 'traditional_art' ? 'selected' : '' }}>Traditional Art</option>
                                <option value="logo_design" {{ old('work_type') == 'logo_design' ? 'selected' : '' }}>Logo Design</option>
                                <option value="book_cover" {{ old('work_type') == 'book_cover' ? 'selected' : '' }}>Book Cover</option>
                                <option value="concept_art" {{ old('work_type') == 'concept_art' ? 'selected' : '' }}>Concept Art</option>
                                <option value="other" {{ old('work_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('work_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline <span class="text-danger">*</span></label>
                            <input id="deadline" type="date" name="deadline" class="form-control" required 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   value="{{ old('deadline') }}">
                            @error('deadline')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Please select a realistic deadline for your project.</div>
                        </div>

                        <!-- Budget Range -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="budget_min" class="form-label">Minimum Budget ($)</label>
                                <input id="budget_min" type="number" name="budget_min" class="form-control" 
                                       step="0.01" min="0" value="{{ old('budget_min') }}" placeholder="0.00">
                                @error('budget_min')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="budget_max" class="form-label">Maximum Budget ($)</label>
                                <input id="budget_max" type="number" name="budget_max" class="form-control" 
                                       step="0.01" min="0" value="{{ old('budget_max') }}" placeholder="0.00">
                                @error('budget_max')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave blank if you have a fixed budget.</div>
                            </div>
                        </div>

                        <!-- Project Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Project Description <span class="text-danger">*</span></label>
                            <textarea id="description" name="description" rows="6" class="form-control" required
                                      placeholder="Please provide a detailed description of your project, including style preferences, size requirements, and any specific details...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Be as detailed as possible to help the artist understand your vision.</div>
                        </div>

                        <!-- References -->
                        <div class="mb-4">
                            <label for="references" class="form-label">References & Inspiration</label>
                            <textarea id="references" name="references" rows="4" class="form-control"
                                      placeholder="Share any reference images, links, or inspiration that might help the artist understand your vision...">{{ old('references') }}</textarea>
                            @error('references')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional: Include links to images, websites, or describe the style you're looking for.</div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('artists.show', $artist) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Profile
                            </a>
                            
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                {{ auth()->user()->role === 'client' ? 'Send Hire Request' : 'Send Commission Request' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips for a Great Commission Request</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Be specific about your vision and requirements</li>
                        <li>Provide clear reference materials when possible</li>
                        <li>Set realistic deadlines and budgets</li>
                        <li>Communicate any special requirements upfront</li>
                        <li>Be open to the artist's suggestions and expertise</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
