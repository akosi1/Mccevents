@extends('admin.layouts.app')
@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit: {{ Str::limit($event->title, 30) }}</h5>
                <a href="{{ route('admin.events.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" id="eventForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Info -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $event->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Date & Location -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $event->location) }}" required>
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Department & Status -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="department" class="form-label fw-semibold">Department</label>
                            <select class="form-select @error('department') is-invalid @enderror" id="department" name="department">
                                <option value="">Select Department (Optional)</option>
                                @foreach(\App\Models\Event::DEPARTMENTS as $code => $name)
                                    <option value="{{ $code }}" {{ old('department', $event->department) == $code ? 'selected' : '' }}>
                                        {{ $code }} - {{ Str::limit($name, 30) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="postponed" {{ old('status', $event->status) == 'postponed' ? 'selected' : '' }}>Postponed</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Cancel Reason -->
                    <div class="row mb-3" id="cancelReasonRow" style="display: {{ in_array(old('status', $event->status), ['postponed', 'cancelled']) ? 'block' : 'none' }};">
                        <div class="col-md-12">
                            <label for="cancel_reason" class="form-label fw-semibold">Reason for Postponement/Cancellation</label>
                            <textarea class="form-control @error('cancel_reason') is-invalid @enderror" 
                                      id="cancel_reason" name="cancel_reason" rows="2">{{ old('cancel_reason', $event->cancel_reason) }}</textarea>
                            @error('cancel_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Event Image</label>
                            
                            @if($event->hasImage())
                            <div class="mb-3" id="currentImageContainer">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted"><i class="fas fa-image me-1"></i>Current Image</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCurrentImage()">
                                        <i class="fas fa-trash me-1"></i>Remove
                                    </button>
                                </div>
                                <div class="image-preview-container">
                                    <img id="currentImage" src="{{ $event->image_url }}" alt="Current Event Image" 
                                         class="img-thumbnail" style="max-height: 200px;">
                                </div>
                                <input type="hidden" id="removeImage" name="remove_image" value="0">
                            </div>
                            @endif
                            
                            <div class="mb-3">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">JPG, PNG, GIF, WebP • Max 2MB</div>
                            </div>
                            
                            <div id="newImagePreview" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i>New Image Preview</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeNewPreview()">
                                        <i class="fas fa-times me-1"></i>Remove
                                    </button>
                                </div>
                                <div class="image-preview-container">
                                    <img id="newPreviewImg" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Event
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Status change handler
document.getElementById('status').addEventListener('change', function() {
    const cancelReasonRow = document.getElementById('cancelReasonRow');
    cancelReasonRow.style.display = ['postponed', 'cancelled'].includes(this.value) ? 'block' : 'none';
});

// Image preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('newPreviewImg').src = e.target.result;
            document.getElementById('newImagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove current image
function removeCurrentImage() {
    document.getElementById('removeImage').value = '1';
    document.getElementById('currentImageContainer').style.display = 'none';
}

// Remove new preview
function removeNewPreview() {
    document.getElementById('image').value = '';
    document.getElementById('newImagePreview').style.display = 'none';
}
</script>
@endpush
@endsection