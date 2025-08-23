// Events Index JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Load create form when modal is shown
    const createModal = document.getElementById('createEventModal');
    if (createModal) {
        createModal.addEventListener('show.bs.modal', function () {
            loadCreateForm();
        });
    }

    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.dataset.eventId;
            const title = this.dataset.title;
            
            Swal.fire({
                title: 'Delete Event?',
                html: `Are you sure you want to delete "<strong>${title}</strong>"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/events/${eventId}`;
                    form.submit();
                }
            });
        });
    });

    // Search with debounce
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => this.form.submit(), 500);
        });
    }
});

// Load create form
function loadCreateForm() {
    const container = document.getElementById('createEventFormContainer');
    const baseUrl = window.location.origin;
    
    container.innerHTML = `
        <form action="${baseUrl}/admin/events" method="POST" enctype="multipart/form-data" id="createEventForm">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
            
            <!-- Basic Info -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="create_title" class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="create_title" name="title" required placeholder="Enter event title">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="create_description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="create_description" name="description" rows="4" required placeholder="Describe your event..."></textarea>
                </div>
            </div>

            <!-- Date & Location -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="create_date" class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="create_date" name="date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="create_location" class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="create_location" name="location" required placeholder="Event location">
                </div>
            </div>

            <!-- Department & Status -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="create_department" class="form-label fw-semibold">Department</label>
                    <select class="form-select" id="create_department" name="department">
                        <option value="">Select Department (Optional)</option>
                        <option value="BSIT">BSIT - Bachelor of Science in Information Technology</option>
                        <option value="BSBA">BSBA - Bachelor of Science in Business Administration</option>
                        <option value="BSED">BSED - Bachelor of Science in Education</option>
                        <option value="BEED">BEED - Bachelor of Elementary Education</option>
                        <option value="BSHM">BSHM - Bachelor of Science in Hospitality Management</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="create_status" class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="create_status" name="status">
                        <option value="active" selected>Active</option>
                        <option value="postponed">Postponed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Cancel Reason (hidden by default) -->
            <div class="row" id="create_cancelReasonRow" style="display: none;">
                <div class="col-md-12 mb-3">
                    <label for="create_cancel_reason" class="form-label fw-semibold">Reason for Postponement/Cancellation</label>
                    <textarea class="form-control" id="create_cancel_reason" name="cancel_reason" rows="2" placeholder="Provide reason..."></textarea>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="create_image" class="form-label fw-semibold">Event Image</label>
                <input type="file" class="form-control" id="create_image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                <div class="form-text">Supported: JPG, PNG, GIF. Max size: 2MB</div>
                
                <!-- Preview -->
                <div id="create_imagePreview" class="mt-3" style="display: none;">
                    <div class="border rounded p-2 bg-light">
                        <img id="create_previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeCreatePreview()">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Create Event
                </button>
            </div>
        </form>
    `;

    // Initialize create form functionality
    initializeCreateForm();
}

// Initialize create form
function initializeCreateForm() {
    const statusSelect = document.getElementById('create_status');
    const cancelReasonRow = document.getElementById('create_cancelReasonRow');
    const imageInput = document.getElementById('create_image');
    
    // Set minimum date to today
    const dateInput = document.getElementById('create_date');
    const now = new Date();
    const minDate = now.toISOString().slice(0, 16);
    dateInput.min = minDate;
    
    // Show/hide cancel reason based on status
    statusSelect.addEventListener('change', function() {
        cancelReasonRow.style.display = ['postponed', 'cancelled'].includes(this.value) ? 'block' : 'none';
    });
    
    // Image preview
    imageInput.addEventListener('change', function() {
        previewCreateImage(this);
    });
    
    // Form validation
    document.getElementById('createEventForm').addEventListener('submit', function(e) {
        const title = document.getElementById('create_title').value.trim();
        const description = document.getElementById('create_description').value.trim();
        const date = document.getElementById('create_date').value;
        const location = document.getElementById('create_location').value.trim();
        
        if (!title || !description || !date || !location) {
            e.preventDefault();
            Swal.fire({
                title: 'Validation Error',
                text: 'Please fill in all required fields.',
                icon: 'error'
            });
            return;
        }
        
        // Check if date is in the past
        const selectedDate = new Date(date);
        const now = new Date();
        if (selectedDate < now) {
            e.preventDefault();
            Swal.fire({
                title: 'Invalid Date',
                text: 'Event date cannot be in the past.',
                icon: 'error'
            });
            return;
        }
    });
}

// Image preview for create form
function previewCreateImage(input) {
    const preview = document.getElementById('create_imagePreview');
    const img = document.getElementById('create_previewImg');
    
    if (input.files && input.files[0]) {
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (input.files[0].size > 2 * 1024 * 1024) {
            Swal.fire({
                title: 'File Too Large',
                text: 'File size must be less than 2MB',
                icon: 'error'
            });
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

// Remove create preview
function removeCreatePreview() {
    document.getElementById('create_image').value = '';
    document.getElementById('create_imagePreview').style.display = 'none';
}

// Edit event function
function editEvent(eventId) {
    // Load edit form via AJAX
    fetch(`/admin/events/${eventId}/edit`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('editEventFormContainer').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading edit form:', error);
            Swal.fire({
                title: 'Error',
                text: 'Failed to load edit form. Please try again.',
                icon: 'error'
            });
        });
}

// View event function
function viewEvent(eventId) {
    window.location.href = `/admin/events/${eventId}`;
}

// Success message handler
function showSuccessMessage(message) {
    Swal.fire({
        title: 'Success!',
        text: message,
        icon: 'success',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
}