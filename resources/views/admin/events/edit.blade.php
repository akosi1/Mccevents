<!-- Edit Event Modal Form Content -->
<form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" id="editEventForm">
    @csrf
    @method('PUT')
    
    <!-- Basic Info -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="edit_title" class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                   id="edit_title" name="title" value="{{ old('title', $event->title) }}" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        
        <div class="col-md-12 mb-3">
            <label for="edit_description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="edit_description" name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <!-- Date & Location -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="edit_date" class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" 
                   id="edit_date" name="date" value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}" required>
            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_location" class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                   id="edit_location" name="location" value="{{ old('location', $event->location) }}" required>
            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <!-- Department & Status -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="edit_department" class="form-label fw-semibold">Department</label>
            <select class="form-select @error('department') is-invalid @enderror" id="edit_department" name="department">
                <option value="">Select Department (Optional)</option>
                <option value="BSIT" {{ old('department', $event->department) == 'BSIT' ? 'selected' : '' }}>BSIT - Bachelor of Science in Information Technology</option>
                <option value="BSBA" {{ old('department', $event->department) == 'BSBA' ? 'selected' : '' }}>BSBA - Bachelor of Science in Business Administration</option>
                <option value="BSED" {{ old('department', $event->department) == 'BSED' ? 'selected' : '' }}>BSED - Bachelor of Science in Education</option>
                <option value="BEED" {{ old('department', $event->department) == 'BEED' ? 'selected' : '' }}>BEED - Bachelor of Elementary Education</option>
                <option value="BSHM" {{ old('department', $event->department) == 'BSHM' ? 'selected' : '' }}>BSHM - Bachelor of Science in Hospitality Management</option>
            </select>
            @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_status" class="form-label fw-semibold">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="edit_status" name="status">
                <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="postponed" {{ old('status', $event->status) == 'postponed' ? 'selected' : '' }}>Postponed</option>
                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <!-- Cancel Reason -->
    <div class="row" id="edit_cancelReasonRow" style="display: {{ in_array(old('status', $event->status), ['postponed', 'cancelled']) ? 'block' : 'none' }};">
        <div class="col-md-12 mb-3">
            <label for="edit_cancel_reason" class="form-label fw-semibold">Reason for Postponement/Cancellation</label>
            <textarea class="form-control @error('cancel_reason') is-invalid @enderror" 
                      id="edit_cancel_reason" name="cancel_reason" rows="2">{{ old('cancel_reason', $event->cancel_reason) }}</textarea>
            @error('cancel_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <!-- Image Upload -->
    <div class="mb-4">
        <label class="form-label fw-semibold">Event Image</label>
        
        @if($event->hasImage())
        <div class="mb-3" id="edit_currentImageContainer">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted"><i class="fas fa-image me-1"></i>Current Image</span>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeEditCurrentImage()">
                    <i class="fas fa-trash me-1"></i>Remove
                </button>
            </div>
            <div class="image-preview-container">
                <img id="edit_currentImage" src="{{ $event->image_url }}" alt="Current Event Image" 
                     class="img-thumbnail" style="max-height: 200px;">
            </div>
            <input type="hidden" id="edit_removeImage" name="remove_image" value="0">
        </div>
        @endif
        
        <div class="mb-3">
            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                   id="edit_image" name="image" accept="image/*">
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">JPG, PNG, GIF, WebP • Max 2MB</div>
        </div>
        
        <div id="edit_newImagePreview" style="display: none;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-success"><i class="fas fa-check-circle me-1"></i>New Image Preview</span>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeEditNewPreview()">
                    <i class="fas fa-times me-1"></i>Remove
                </button>
            </div>
            <div class="image-preview-container">
                <img id="edit_newPreviewImg" class="img-thumbnail" style="max-height: 200px;">
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancel
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Update Event
        </button>
    </div>
</form>

<script>
// Initialize edit form functionality
document.addEventListener('DOMContentLoaded', function() {
    const editStatusSelect = document.getElementById('edit_status');
    const editCancelReasonRow = document.getElementById('edit_cancelReasonRow');
    const editImageInput = document.getElementById('edit_image');
    
    // Show/hide cancel reason based on status
    if (editStatusSelect) {
        editStatusSelect.addEventListener('change', function() {
            editCancelReasonRow.style.display = ['postponed', 'cancelled'].includes(this.value) ? 'block' : 'none';
        });
    }
    
    // Image preview
    if (editImageInput) {
        editImageInput.addEventListener('change', function() {
            previewEditImage(this);
        });
    }
});

// Image preview for edit form
function previewEditImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('edit_newPreviewImg').src = e.target.result;
            document.getElementById('edit_newImagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove current image in edit form
function removeEditCurrentImage() {
    document.getElementById('edit_removeImage').value = '1';
    document.getElementById('edit_currentImageContainer').style.display = 'none';
}

// Remove new preview in edit form
function removeEditNewPreview() {
    document.getElementById('edit_image').value = '';
    document.getElementById('edit_newImagePreview').style.display = 'none';
}
</script>