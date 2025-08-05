    @extends('admin.layouts.app')
    @section('title', 'Create Event')
    @section('page-title', 'Create New Event')

    @section('content')
    <?
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
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                    id="date" name="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required>
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
                                    @foreach(\App\Models\Event::DEPARTMENTS as $code => $name)
                                        <option value="{{ $code }}" {{ old('department') == $code ? 'selected' : '' }}>
                                            {{ $code }} - {{ Str::limit($name, 30) }}
                                        </option>
                                    @endforeach
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
                        <div class="row" id="cancelReasonRow" style="display: none;">
                            <div class="col-md-12 mb-3">
                                <label for="cancel_reason" class="form-label fw-semibold">Reason for Postponement/Cancellation</label>
                                <textarea class="form-control @error('cancel_reason') is-invalid @enderror" 
                                        id="cancel_reason" name="cancel_reason" rows="2" 
                                        placeholder="Provide reason...">{{ old('cancel_reason') }}</textarea>
                                @error('cancel_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Recurring Options -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="repeat_type" class="form-label fw-semibold">Repeat</label>
                                <select class="form-select @error('repeat_type') is-invalid @enderror" id="repeat_type" name="repeat_type">
                                    <option value="none" {{ old('repeat_type', 'none') == 'none' ? 'selected' : '' }}>No Repeat</option>
                                    <option value="daily" {{ old('repeat_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('repeat_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('repeat_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ old('repeat_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('repeat_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3" id="intervalRow" style="display: none;">
                                <label for="repeat_interval" class="form-label fw-semibold">Every</label>
                                <input type="number" class="form-control @error('repeat_interval') is-invalid @enderror" 
                                    id="repeat_interval" name="repeat_interval" value="{{ old('repeat_interval', 1) }}" 
                                    min="1" max="30">
                                @error('repeat_interval')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3" id="untilRow" style="display: none;">
                                <label for="repeat_until" class="form-label fw-semibold">Repeat Until</label>
                                <input type="date" class="form-control @error('repeat_until') is-invalid @enderror" 
                                    id="repeat_until" name="repeat_until" value="{{ old('repeat_until') }}">
                                @error('repeat_until')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Event Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Supported: JPG, PNG, GIF. Max size: 2MB</div>
                            
                            <!-- Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="border rounded p-2 bg-light">
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removePreview()">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-3">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
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
        const repeatTypeSelect = document.getElementById('repeat_type');
        const intervalRow = document.getElementById('intervalRow');
        const untilRow = document.getElementById('untilRow');
        
        // Show/hide cancel reason based on status
        function toggleCancelReason() {
            cancelReasonRow.style.display = ['postponed', 'cancelled'].includes(statusSelect.value) ? 'block' : 'none';
        }
        
        // Show/hide repeat options
        function toggleRepeatOptions() {
            const show = repeatTypeSelect.value !== 'none';
            intervalRow.style.display = show ? 'block' : 'none';
            untilRow.style.display = show ? 'block' : 'none';
        }
        
        // Image preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const img = document.getElementById('previewImg');
            
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
        
        // Remove preview
        window.removePreview = function() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        };
        
        // Event listeners
        statusSelect.addEventListener('change', toggleCancelReason);
        repeatTypeSelect.addEventListener('change', toggleRepeatOptions);
        document.getElementById('image').addEventListener('change', function() {
            previewImage(this);
        });
        
        // Initialize
        toggleCancelReason();
        toggleRepeatOptions();
    });
    </script>
    @endpush
    @endsection