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
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Event
        </a>
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
                        @foreach(\App\Models\Event::DEPARTMENTS as $code => $name)
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
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.events.show', $event) }}" 
                                       class="btn btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                                data-title="{{ $event->title }}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create Event
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const title = this.dataset.title;
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Delete Event?',
                html: `Are you sure you want to delete "<strong>${title}</strong>"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545'
            }).then(result => {
                if (result.isConfirmed) form.submit();
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
</script>

<style>
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

/* Button Groups */
.btn-group .btn {
    border-radius: 8px;
    margin: 0 2px;
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
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

/* Responsive Design */
@media (max-width: 768px) {
    .event-image { width: 48px; height: 48px; }
    .btn-group .btn { padding: 0.25rem 0.375rem; font-size: 0.75rem; }
    .table th:nth-child(2), .table td:nth-child(2) { display: none; }
}

@media (max-width: 576px) {
    .event-image { width: 40px; height: 40px; }
    .table th:nth-child(5), .table td:nth-child(5),
    .table th:nth-child(7), .table td:nth-child(7) { display: none; }
}
</style>
@endpush

@endsection