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
                    @if ($events->onFirstPage())
                        <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $events->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                    @endif

                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                        @if ($page == $events->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

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

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/events-index.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin/events-index.js') }}"></script>
<script>
    // Pass success message to JavaScript
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showSuccessMessage('{{ session('success') }}');
        });
    @endif
</script>
@endpush

@endsection