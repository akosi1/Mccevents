<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EventAP') }} - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2d3748;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Navigation Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.75rem 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .nav-brand {
            color: #667eea;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-content { display: flex; align-items: center; gap: 1.5rem; }

        .nav-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.4);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.6);
            color: white;
            text-decoration: none;
        }

        /* Dropdown Styles */
        .dropdown { position: relative; }

        .dropdown-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .dropdown-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .dropdown-btn.user-btn {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
        }

        .dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }
        .dropdown-menu.right { right: 0; }

        .dropdown-header {
            padding: 1rem 1.25rem 0.5rem;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            color: #2d3748;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background: #f7fafc;
            color: #667eea;
            padding-left: 1.5rem;
            text-decoration: none;
        }

        .dropdown-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .dropdown-item.logout {
            color: #e53e3e;
            border-top: 1px solid #e2e8f0;
            margin-top: 0.5rem;
        }

        .dept-info { display: flex; flex-direction: column; gap: 0.25rem; }
        .dept-code { font-weight: 600; font-size: 0.95rem; }
        .dept-name { font-size: 0.8rem; opacity: 0.7; }

        /* Filter Status */
        .filter-status {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin: 2rem auto;
            max-width: 1400px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .filter-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Events Section */
        .events-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 1400px;
            margin: 2rem auto;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Search Input */
        .search-container { position: relative; max-width: 400px; }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        /* Events Grid */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .event-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .event-image-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }

        .event-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .no-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        }

        .event-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(102, 126, 234, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .event-content { padding: 1.5rem; }

        .event-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .event-description {
            color: #4a5568;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .event-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .event-detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #4a5568;
            font-size: 0.9rem;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            gap: 1rem;
        }

        .event-date-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .join-event-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .join-event-btn:hover {
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
            transform: translateY(-1px);
        }

        .join-event-btn.joined {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        }

        .spinner { 
            border: 2px solid transparent; 
            border-top: 2px solid currentColor; 
            border-radius: 50%; 
            width: 16px; 
            height: 16px; 
            animation: spin 1s linear infinite; 
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 3rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .pagination-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-info {
            margin: 0 2rem;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .pagination-nav {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border: 2px solid #e2e8f0;
            background: white;
            color: #4a5568;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .pagination-btn:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            text-decoration: none;
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .pagination-btn.disabled {
            background: #f7fafc;
            border-color: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .pagination-btn.disabled:hover {
            background: #f7fafc;
            border-color: #e2e8f0;
            color: #a0aec0;
            transform: none;
            box-shadow: none;
        }

        .pagination-btn.prev-next {
            width: 120px;
            gap: 0.5rem;
            padding: 0 1rem;
            font-weight: 600;
        }

        .pagination-btn.prev-next i {
            font-size: 0.8rem;
        }

        .pagination-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            color: #a0aec0;
            font-weight: 600;
        }

        /* Hide default Laravel pagination */
        .pagination {
            display: none !important;
        }

        /* Toast */
        .toast {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #48bb78;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .toast.show { transform: translateX(0); }
        .toast.error { border-left-color: #f56565; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #4a5568;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .nav-container { flex-direction: column; gap: 1rem; }
            .nav-content { flex-wrap: wrap; justify-content: center; }
            .events-grid { grid-template-columns: 1fr; gap: 1rem; }
            .section-header { flex-direction: column; align-items: stretch; }
            .search-container { max-width: 100%; }
            
            .pagination-container {
                margin-top: 2rem;
                padding: 1rem;
            }
            
            .pagination-wrapper {
                flex-direction: column;
                gap: 1rem;
            }
            
            .pagination-info {
                margin: 0;
                order: 2;
            }
            
            .pagination-nav {
                order: 1;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .pagination-btn.prev-next {
                width: 100px;
                font-size: 0.8rem;
            }
            
            .pagination-btn {
                width: 40px;
                height: 40px;
                font-size: 0.8rem;
            }
        }
    </style>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="nav-brand">
                <i class="fas fa-calendar-alt"></i>
                EventAps
            </a>
            
            <div class="nav-content">
                <!-- Dashboard Button -->
                <a href="{{ route('dashboard') }}" class="nav-btn">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                
                <!-- Department Filter -->
                <div class="dropdown" id="deptDropdown">
                    <button class="dropdown-btn" onclick="toggleDropdown('deptDropdown')">
                        <i class="fas fa-graduation-cap"></i>
                        <span id="deptLabel">
                            @if(request('department'))
                                {{ request('department') }}
                            @else
                                Departments
                            @endif
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">Select Department</div>
                        @php
                            $departments = [
                                'BSIT' => 'Information Technology',
                                'BSBA' => 'Business Administration',
                                'BSED' => 'Science in Education',
                                'BEED' => 'Elementary Education',
                                'BSHM' => 'Hospitality Management'
                            ];
                        @endphp
                        
                        @foreach($departments as $code => $name)
                            <a href="{{ route('dashboard', array_merge(request()->query(), ['department' => $code])) }}" 
                               class="dropdown-item {{ request('department') === $code ? 'active' : '' }}">
                                <i class="fas fa-graduation-cap"></i>
                                <div class="dept-info">
                                    <div class="dept-code">{{ $code }}</div>
                                    <div class="dept-name">{{ $name }}</div>
                                </div>
                            </a>
                        @endforeach
                        
                        <div style="height: 1px; background: #e2e8f0; margin: 0.5rem 0;"></div>
                        <a href="{{ route('dashboard', request()->except('department')) }}" 
                           class="dropdown-item logout">
                            <i class="fas fa-times"></i>
                            Clear Filter
                        </a>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="dropdown" id="userDropdown">
                    <button class="dropdown-btn user-btn" onclick="toggleDropdown('userDropdown')">
                        <i class="fas fa-user-circle"></i>
                        {{ auth()->user()->first_name }}
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu right">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Filter Status Banner -->
    @if(request('department'))
        <div class="filter-status">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-filter"></i>
                <span>Filtering by: <strong>{{ request('department') }} - {{ $departments[request('department')] ?? '' }}</strong></span>
            </div>
            <a href="{{ route('dashboard', request()->except('department')) }}" class="filter-close">
                <i class="fas fa-times"></i>
            </a>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Events Section -->
            <div class="events-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-fire"></i>
                        Latest Events
                    </h2>
                    
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <form method="GET" action="{{ route('dashboard') }}">
                            @foreach(request()->except('search') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="text" 
                                   name="search" 
                                   class="search-input" 
                                   placeholder="Search events..." 
                                   value="{{ request('search') }}"
                                   onchange="this.form.submit()">
                        </form>
                    </div>
                </div>

                @if($events->count() > 0)
                    <!-- Events Grid -->
                    <div class="events-grid">
                        @foreach($events as $event)
                        <div class="event-card">
                            <div class="event-image-container">
                                @if($event->image && Storage::disk('public')->exists($event->image))
                                    <img src="{{ Storage::url($event->image) }}" 
                                         alt="{{ $event->title }}" 
                                         class="event-image">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image" style="font-size: 3rem; color: #a0aec0;"></i>
                                    </div>
                                @endif
                                <div class="event-badge">
                                    @if($event->created_at >= now()->subWeek())
                                        NEW
                                    @elseif($event->date >= now() && $event->date <= now()->addWeek())
                                        UPCOMING
                                    @elseif($event->is_recurring)
                                        RECURRING
                                    @else
                                        EVENT
                                    @endif
                                </div>
                                
                                <!-- Exclusivity Badge -->
                                @if($event->is_exclusive)
                                    <div class="exclusivity-badge exclusive">
                                        <i class="fas fa-lock"></i>
                                        EXCLUSIVE
                                    </div>
                                @else
                                    <div class="exclusivity-badge open">
                                        <i class="fas fa-globe"></i>
                                        OPEN
                                    </div>
                                @endif
                            </div>
                            <div class="event-content">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                                
                                <div class="event-details">
                                    <div class="event-detail-item">
                                        <i class="fas fa-calendar" style="width: 16px; color: #667eea;"></i>
                                        <span>{{ $event->date->format('F d, Y') }}</span>
                                    </div>
                                    @if($event->start_time)
                                    <div class="event-detail-item">
                                        <i class="fas fa-clock" style="width: 16px; color: #667eea;"></i>
                                        <span>{{ $event->start_time->format('g:i A') }}@if($event->end_time) - {{ $event->end_time->format('g:i A') }}@endif</span>
                                    </div>
                                    @endif
                                    <div class="event-detail-item">
                                        <i class="fas fa-map-marker-alt" style="width: 16px; color: #667eea;"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    <div class="event-detail-item">
                                        <i class="fas fa-graduation-cap" style="width: 16px; color: #667eea;"></i>
                                        <span>{{ $event->department_display }}</span>
                                    </div>
                                    @if($event->is_recurring)
                                    <div class="event-detail-item">
                                        <i class="fas fa-repeat" style="width: 16px; color: #667eea;"></i>
                                        <span>{{ $event->recurrence_display }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="event-footer">
                                    <div class="event-date-badge">{{ $event->date->format('M d') }}</div>
                                    <button class="join-event-btn {{ $event->is_joined ? 'joined' : '' }}" 
                                            data-event-id="{{ $event->id }}" 
                                            data-joined="{{ $event->is_joined ? 'true' : 'false' }}"
                                            onclick="toggleEventJoin(this)">
                                        <span class="btn-icon">
                                            @if($event->is_joined)
                                                <i class="fas fa-minus"></i>
                                            @else
                                                <i class="fas fa-plus"></i>
                                            @endif
                                        </span>
                                        <span class="btn-text">
                                            {{ $event->is_joined ? 'Leave Event' : 'Join Event' }}
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Custom Pagination -->
                    @if($events->hasPages())
                        <div class="pagination-container">
                            <div class="pagination-wrapper">
                                <div class="pagination-nav">
                                    {{-- Previous Page Link --}}
                                    @if ($events->onFirstPage())
                                        <span class="pagination-btn prev-next disabled">
                                            <i class="fas fa-chevron-left"></i>
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $events->previousPageUrl() }}" class="pagination-btn prev-next">
                                            <i class="fas fa-chevron-left"></i>
                                            Previous
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                                        @if ($page == $events->currentPage())
                                            <span class="pagination-btn active">{{ $page }}</span>
                                        @elseif ($page == 1 || $page == $events->lastPage() || ($page >= $events->currentPage() - 2 && $page <= $events->currentPage() + 2))
                                            <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                                        @elseif ($page == $events->currentPage() - 3 || $page == $events->currentPage() + 3)
                                            <span class="pagination-dots">...</span>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($events->hasMorePages())
                                        <a href="{{ $events->nextPageUrl() }}" class="pagination-btn prev-next">
                                            Next
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @else
                                        <span class="pagination-btn prev-next disabled">
                                            Next
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="pagination-info">
                                    Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} results
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Hide default Laravel pagination -->
                    <div style="display: none;">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-calendar-times" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">No events available</h3>
                        <p style="opacity: 0.8;">
                            @if(request('department') || request('search'))
                                No events match your current filters. Try adjusting your search criteria.
                            @else
                                There are no events available for your department at the moment. Please check back later.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div id="toastContainer"></div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Dropdown functionality
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const menu = dropdown.querySelector('.dropdown-menu');
            const isOpen = menu.classList.contains('show');
            
            // Close all dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('show'));
            
            if (!isOpen) {
                menu.classList.add('show');
                dropdown.classList.add('show');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('show'));
            }
        });

        // Toast notification system
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            const container = document.getElementById('toastContainer');
            container.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => container.removeChild(toast), 300);
            }, 3000);
        }

        // Toggle event join/leave functionality
        async function toggleEventJoin(button) {
            const eventId = button.getAttribute('data-event-id');
            const isJoined = button.getAttribute('data-joined') === 'true';
            const btnIcon = button.querySelector('.btn-icon i');
            const btnText = button.querySelector('.btn-text');
            
            button.disabled = true;
            btnIcon.className = 'spinner';
            btnText.textContent = isJoined ? 'Leaving...' : 'Joining...';
            
            try {
                const url = `/events/${eventId}/${isJoined ? 'leave' : 'join'}`;
                const method = isJoined ? 'DELETE' : 'POST';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const newJoinedState = !isJoined;
                    button.setAttribute('data-joined', newJoinedState ? 'true' : 'false');
                    button.className = `join-event-btn ${newJoinedState ? 'joined' : ''}`;
                    
                    btnIcon.className = newJoinedState ? 'fas fa-minus' : 'fas fa-plus';
                    btnText.textContent = newJoinedState ? 'Leave Event' : 'Join Event';
                    
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                    btnIcon.className = isJoined ? 'fas fa-minus' : 'fas fa-plus';
                    btnText.textContent = isJoined ? 'Leave Event' : 'Join Event';
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
                btnIcon.className = isJoined ? 'fas fa-minus' : 'fas fa-plus';
                btnText.textContent = isJoined ? 'Leave Event' : 'Join Event';
            } finally {
                button.disabled = false;
            }
        }

        // Keyboard shortcut for search
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('.search-input').focus();
            }
        });

        // Smooth scroll for pagination clicks
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!this.classList.contains('disabled') && !this.classList.contains('active')) {
                    // Add a subtle loading state
                    this.style.opacity = '0.7';
                    setTimeout(() => {
                        this.style.opacity = '';
                    }, 200);
                }
            });
        });

        // Add hover effects for better UX
        document.querySelectorAll('.pagination-btn:not(.disabled)').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(-2px)';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = '';
                }
            });
        });
    </script>
</body>
</html>