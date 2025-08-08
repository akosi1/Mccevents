@extends('admin.layouts.app')
@section('title', 'Events Management')
@section('page-title', 'Events Management')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1">
                <i class="fas fa-calendar-alt text-primary me-2"></i>Events Management
            </h2>
            <p class="text-muted mb-0">{{ $events->total() }} total events</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
            <i class="fas fa-plus me-2"></i>Add Event
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="Search events...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach(['active', 'postponed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="department" onchange="this.form.submit()">
                        <option value="">All Departments</option>
                        @foreach(['BSIT' => 'Bachelor of Science in Information Technology', 'BSBA' => 'Bachelor of Science in Business Administration', 'BSED' => 'Bachelor of Science in Education', 'BEED' => 'Bachelor of Elementary Education', 'BSHM' => 'Bachelor of Science in Hospitality Management'] as $code => $name)
                            <option value="{{ $code }}" {{ request('department') == $code ? 'selected' : '' }}>
                                {{ $code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="per_page" onchange="this.form.submit()">
                        @foreach([10, 25, 50] as $num)
                            <option value="{{ $num }}" {{ request('per_page') == $num ? 'selected' : '' }}>
                                {{ $num }} items
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($events->count())
        <!-- Events Table -->
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th class="py-3">Image</th>
                            <th class="py-3">Event</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Department</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Location</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td class="ps-4 py-3 align-middle">
                                <span class="text-muted fw-medium">#{{ $event->id }}</span>
                            </td>
                            <td class="py-3 align-middle">
                                <div class="event-image">
                                    @if($event->image && file_exists(public_path('storage/' . $event->image)))
                                        <img src="{{ asset('storage/' . $event->image) }}" 
                                             alt="{{ $event->title }}" 
                                             class="event-img"
                                             onerror="this.parentElement.innerHTML='<div class=\'no-image\'><i class=\'fas fa-image\'></i></div>'">
                                    @elseif($event->image)
                                        <!-- Fallback for direct URL or different storage -->
                                        <img src="{{ $event->image }}" 
                                             alt="{{ $event->title }}" 
                                             class="event-img"
                                             onerror="this.parentElement.innerHTML='<div class=\'no-image\'><i class=\'fas fa-image\'></i></div>'">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ Str::limit($event->title, 35) }}</h6>
                                    <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <div class="fw-medium">{{ $event->date->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $event->date->format('h:i A') }}</small>
                            </td>
                            <td class="py-3 align-middle">
                                @if($event->department)
                                    <span class="badge bg-primary">{{ $event->department }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 align-middle">
                                <span class="badge status-{{ $event->status }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="py-3 align-middle">
                                <span class="text-muted" title="{{ $event->location }}">{{ Str::limit($event->location, 20) }}</span>
                            </td>
                            <td class="py-3 align-middle text-center">
                                <div class="action-buttons d-flex justify-content-center gap-1">
                                    <button class="btn btn-clean btn-view" title="View" onclick="viewEvent({{ $event->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-clean btn-edit" title="Edit" onclick="editEvent({{ $event->id }})" data-bs-toggle="modal" data-bs-target="#editEventModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-clean btn-delete delete-btn" title="Delete" data-event-id="{{ $event->id }}" data-title="{{ $event->title }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enhanced Pagination -->
        @if($events->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="pagination-info">
                <span class="text-muted">
                    Showing {{ $events->firstItem() }}-{{ $events->lastItem() }} of {{ $events->total() }} results
                </span>
            </div>
            
            <nav aria-label="Events pagination">
                <ul class="pagination pagination-sm mb-0">
                    {{-- Previous Page Link --}}
                    @if ($events->onFirstPage())
                        <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $events->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                        @if ($page == $events->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($events->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $events->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-alt fa-4x text-muted mb-4"></i>
                <h5 class="text-muted mb-3">No Events Found</h5>
                <p class="text-muted mb-4">
                    {{ request()->hasAny(['search', 'status', 'department']) 
                       ? 'No events match your search criteria.' 
                       : 'Get started by creating your first event!' }}
                </p>
                <div>
                    @if(request()->hasAny(['search', 'status', 'department']))
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary me-2">
                            Clear Filters
                        </a>
                    @endif
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
                        <i class="fas fa-plus me-1"></i>Create Event
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createEventModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Create New Event
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create form content will be loaded here -->
                <div id="createEventFormContainer">
                    <!-- Form will be dynamically loaded -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editEventModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form content will be loaded here -->
                <div id="editEventFormContainer">
                    <!-- Form will be dynamically loaded -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf @method('DELETE')
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load create form when modal is shown
    const createModal = document.getElementById('createEventModal');
    createModal.addEventListener('show.bs.modal', function () {
        loadCreateForm();
    });

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
    
    // Success message
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif

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
    container.innerHTML = `
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="createEventForm">
            @csrf
            
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
    
    // Show/hide cancel reason based on status
    statusSelect.addEventListener('change', function() {
        cancelReasonRow.style.display = ['postponed', 'cancelled'].includes(this.value) ? 'block' : 'none';
    });
    
    // Image preview
    imageInput.addEventListener('change', function() {
        previewCreateImage(this);
    });
}

// Image preview for create form
function previewCreateImage(input) {
    const preview = document.getElementById('create_imagePreview');
    const img = document.getElementById('create_previewImg');
    
    if (input.files && input.files[0]) {
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
        });
}

// View event function
function viewEvent(eventId) {
    window.location.href = `/admin/events/${eventId}`;
}
</script>

<style>
/* Clean Action Buttons */
.action-buttons {
    gap: 4px;
}

.btn-clean {
    background: none;
    border: none;
    padding: 8px 10px;
    border-radius: 8px;
    transition: all 0.2s ease;
    color: #6b7280;
    font-size: 14px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-clean:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-view:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

/* Event Image Styling */
.event-image {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e2e8f0;
    position: relative;
}

.event-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.2s ease;
}

.event-image:hover .event-img {
    transform: scale(1.05);
}

.no-image {
    color: #94a3b8;
    font-size: 20px;
}

/* Status Badges */
.status-active { 
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}
.status-postponed { 
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}
.status-cancelled { 
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

/* Table Styling */
.table {
    --bs-table-hover-bg: rgba(79, 70, 229, 0.04);
}

.table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: #475569;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    border-bottom: 2px solid #e2e8f0;
}

/* Enhanced Pagination */
.pagination {
    border-radius: 10px;
}

.page-link {
    border-radius: 8px !important;
    margin: 0 2px;
    border: 1px solid #d1d5db;
    color: #6b7280;
    transition: all 0.15s ease;
    padding: 0.5rem 0.75rem;
}

.page-link:hover {
    background-color: #4f46e5;
    border-color: #4f46e5;
    color: white;
    transform: translateY(-1px);
}

.page-item.active .page-link {
    background-color: #4f46e5;
    border-color: #4f46e5;
}

.page-item.disabled .page-link {
    color: #9ca3af;
    background-color: #f9fafb;
}

/* Cards */
.card {
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

/* Form Controls */
.form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #d1d5db;
    transition: all 0.15s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

/* Primary Button */
.btn-primary {
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    border: none;
    border-radius: 10px;
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    transition: all 0.15s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #4338ca, #3730a3);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
}

/* Modal Styling */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-radius: 16px 16px 0 0;
    border-bottom: 1px solid #e5e7eb;
}

/* Responsive Design */
@media (max-width: 768px) {
    .event-image { width: 48px; height: 48px; }
    .btn-clean { width: 32px; height: 32px; padding: 6px; font-size: 12px; }
    .table th:nth-child(2), .table td:nth-child(2) { display: none; }
    .action-buttons { gap: 2px; }
}

@media (max-width: 576px) {
    .event-image { width: 40px; height: 40px; }
    .table th:nth-child(5), .table td:nth-child(5),
    .table th:nth-child(7), .table td:nth-child(7) { display: none; }
    .btn-clean { width: 30px; height: 30px; }
}
</style>
@endpush

@endsection