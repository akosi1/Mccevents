@extends('admin.layouts.app')
@section('title', 'Create Event')
@section('page-title', 'Create New Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Event Details</h5>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="eventForm">
                    @csrf
                    
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title') }}" required placeholder="Enter event title">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="4" required 
                                    placeholder="Describe your event...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Date & Location -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" 
                                id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                id="location" name="location" value="{{ old('location') }}" required 
                                placeholder="Event location">
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Department & Status -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label fw-semibold">Department</label>
                            <select class="form-select @error('department') is-invalid @enderror" id="department" name="department">
                                <option value="">Select Department (Optional)</option>
                                <option value="BSIT" {{ old('department') == 'BSIT' ? 'selected' : '' }}>BSIT - Bachelor of Science in Information Technology</option>
                                <option value="BSBA" {{ old('department') == 'BSBA' ? 'selected' : '' }}>BSBA - Bachelor of Science in Business Administration</option>
                                <option value="BSED" {{ old('department') == 'BSED' ? 'selected' : '' }}>BSED - Bachelor of Science in Education</option>
                                <option value="BEED" {{ old('department') == 'BEED' ? 'selected' : '' }}>BEED - Bachelor of Elementary Education</option>
                                <option value="BSHM" {{ old('department') == 'BSHM' ? 'selected' : '' }}>BSHM - Bachelor of Science in Hospitality Management</option>
                            </select>
                            @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="postponed" {{ old('status') == 'postponed' ? 'selected' : '' }}>Postponed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Cancel Reason (hidden by default) -->
                    <div class="row" id="cancelReasonRow" style="display: {{ in_array(old('status'), ['postponed', 'cancelled']) ? 'block' : 'none' }};">
                        <div class="col-md-12 mb-3">
                            <label for="cancel_reason" class="form-label fw-semibold">Reason for Postponement/Cancellation</label>
                            <textarea class="form-control @error('cancel_reason') is-invalid @enderror" 
                                    id="cancel_reason" name="cancel_reason" rows="2" 
                                    placeholder="Provide reason...">{{ old('cancel_reason') }}</textarea>
                            @error('cancel_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">Event Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                            id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Supported: JPG, PNG, GIF, WebP. Max size: 2MB</div>
                        
                        <!-- Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <div class="border rounded p-3 bg-light">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i>Image Preview</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePreview()">
                                        <i class="fas fa-times me-1"></i>Remove
                                    </button>
                                </div>
                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-3">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i>Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const cancelReasonRow = document.getElementById('cancelReasonRow');
    const imageInput = document.getElementById('image');
    
    // Show/hide cancel reason based on status
    function toggleCancelReason() {
        cancelReasonRow.style.display = ['postponed', 'cancelled'].includes(statusSelect.value) ? 'block' : 'none';
    }
    
    // Image preview
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const img = document.getElementById('previewImg');
        
        if (input.files && input.files[0]) {
            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (input.files[0].size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                input.value = '';
                preview.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
    
    // Remove preview
    window.removePreview = function() {
        document.getElementById('image').value = '';
        document.getElementById('imagePreview').style.display = 'none';
    };
    
    // Event listeners
    statusSelect.addEventListener('change', toggleCancelReason);
    imageInput.addEventListener('change', function() {
        previewImage(this);
    });
    
    // Form validation
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const date = document.getElementById('date').value;
        const location = document.getElementById('location').value.trim();
        
        if (!title || !description || !date || !location) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return;
        }
        
        // Check if date is in the past
        const selectedDate = new Date(date);
        const now = new Date();
        if (selectedDate < now) {
            e.preventDefault();
            alert('Event date cannot be in the past.');
            return;
        }
    });
    
    // Initialize
    toggleCancelReason();
    
    // Set minimum date to today
    const dateInput = document.getElementById('date');
    const now = new Date();
    const minDate = now.toISOString().slice(0, 16);
    dateInput.min = minDate;
});
</script>

<style>
/* Enhanced Card Styling */
.card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.card-header {
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    border-radius: 16px 16px 0 0 !important;
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

.card-body {
    padding: 2rem;
}

/* Form Controls */
.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    font-size: 0.95rem;
}

.form-control:focus, .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.1);
    transform: translateY(-1px);
}

.form-label {
    color: #374151;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Buttons */
.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 2px solid transparent;
}

.btn-primary {
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    border: none;
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #4338ca, #3730a3);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
}

.btn-outline-secondary {
    border-color: #d1d5db;
    color: #6b7280;
}

.btn-outline-secondary:hover {
    background-color: #f9fafb;
    border-color: #9ca3af;
    transform: translateY(-1px);
}

.btn-outline-danger {
    border-color: #fca5a5;
    color: #dc2626;
    font-size: 0.85rem;
}

.btn-outline-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
    color: white;
}

/* Image Preview */
#imagePreview {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

#imagePreview .border {
    border: 2px dashed #d1d5db !important;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    transition: all 0.2s ease;
}

#imagePreview:hover .border {
    border-color: #4f46e5 !important;
}

/* Text Areas */
textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Required Field Indicator */
.text-danger {
    color: #ef4444 !important;
}

/* Invalid Feedback */
.invalid-feedback {
    font-size: 0.85rem;
    font-weight: 500;
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.1);
}

/* Form Text */
.form-text {
    color: #6b7280;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .btn {
        padding: 0.625rem 1.25rem;
        font-size: 0.9rem;
    }
}
</style>
@endpush
@endsection