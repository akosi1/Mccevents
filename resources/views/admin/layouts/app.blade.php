    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Admin Panel') - EventAP</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        
        @stack('styles')
        
        <style>
            :root {
                --sidebar-width: 250px;
                --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            * { box-sizing: border-box; }
            
            body {
                background-color: #f8f9fa;
                overflow-x: hidden;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            /* Sidebar */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: var(--sidebar-width);
                background: var(--primary-gradient);
                box-shadow: 2px 0 15px rgba(0,0,0,0.1);
                transform: translateX(0);
                transition: var(--transition);
                z-index: 1000;
                overflow-y: auto;
            }
            
            .sidebar.hidden {
                transform: translateX(-100%);
            }
            
            .sidebar-header {
                padding: 1.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.1);
                text-align: center;
            }
            
            .sidebar-header img {
                max-width: 60px;
                filter: brightness(1.1);
            }
            
            .sidebar-header h4 {
                font-size: 1.1rem;
                font-weight: 600;
                margin: 0.5rem 0 0.25rem;
            }
            
            .sidebar-close {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: none;
                border: none;
                color: rgba(255,255,255,0.8);
                font-size: 1.2rem;
                cursor: pointer;
                padding: 0.5rem;
                border-radius: 50%;
                transition: var(--transition);
            }
            
            .sidebar-close:hover {
                background: rgba(255,255,255,0.2);
                color: white;
            }
            
            /* Navigation */
            .sidebar-nav {
                padding: 1rem 0;
            }
            
            .nav-link {
                color: rgba(255,255,255,0.8);
                padding: 0.875rem 1.5rem;
                border-radius: 8px;
                margin: 0.25rem 1rem;
                transition: var(--transition);
                text-decoration: none;
                display: flex;
                align-items: center;
                font-weight: 500;
            }
            
            .nav-link i {
                width: 20px;
                margin-right: 0.75rem;
            }
            
            .nav-link:hover,
            .nav-link.active {
                color: white;
                background: rgba(255,255,255,0.2);
                transform: translateX(5px);
                text-decoration: none;
            }
            
            /* Main Content */
            .main-content {
                margin-left: var(--sidebar-width);
                background: white;
                min-height: 100vh;
                border-radius: 15px 0 0 0;
                box-shadow: -2px 0 15px rgba(0,0,0,0.1);
                transition: var(--transition);
            }
            
            .main-content.expanded {
                margin-left: 0;
                border-radius: 0;
            }
            
            /* Navbar */
            .navbar {
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
                border-radius: 15px 15px 0 0;
                position: sticky;
                top: 0;
                z-index: 999;
                padding: 1rem 1.5rem;
            }
            
            .main-content.expanded .navbar {
                border-radius: 0;
            }
            
            /* Toggle Button */
            .sidebar-toggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1001;
                background: rgba(102, 126, 234, 0.9);
                backdrop-filter: blur(10px);
                border: none;
                color: white;
                padding: 0.75rem;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                transition: var(--transition);
                cursor: pointer;
                opacity: 0;
                transform: translateX(-60px);
                pointer-events: none;
            }
            
            .sidebar-toggle:hover {
                background: rgba(102, 126, 234, 1);
                transform: translateX(-60px) translateY(-2px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            }
            
            .sidebar-toggle.show {
                opacity: 1;
                transform: translateX(0);
                pointer-events: all;
            }
            
            /* Overlay */
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
            }
            
            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }
            
            /* Cards & Components */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                margin-bottom: 1.5rem;
            }
            
            .btn-primary {
                background: var(--primary-gradient);
                border: none;
                border-radius: 8px;
                transition: var(--transition);
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            }
            
            /* Scrollbar */
            .sidebar::-webkit-scrollbar { width: 4px; }
            .sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
            .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }
            
            /* Mobile Responsive */
            @media (max-width: 768px) {
                .sidebar {
                    width: 280px;
                    transform: translateX(-100%);
                }
                
                .sidebar.show {
                    transform: translateX(0);
                }
                
                .main-content {
                    margin-left: 0;
                    border-radius: 0;
                }
                
                .navbar { border-radius: 0; }
                
                .sidebar-toggle {
                    opacity: 1;
                    transform: translateX(0);
                    pointer-events: all;
                }
            }
            
            @media (max-width: 576px) {
                .sidebar { width: 100vw; }
                .sidebar-toggle { top: 0.75rem; left: 0.75rem; }
            }
            
            /* Animations */
            .fade-in {
                animation: fadeIn 0.3s ease-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body>
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/admin.png') }}" alt="EventAP Logo" class="img-fluid mb-2">
                <h4 class="text-white mb-1">Event & Portfolio Organizer</h4>
                <small class="text-white-50">Admin Panel</small>
                <button class="sidebar-close" id="sidebarClose" aria-label="Close Sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" 
                href="{{ route('admin.events.index') }}">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Users
                </a>
            </nav>
        </div>

        <div class="main-content" id="mainContent">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <h5 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h5>
                    <div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/admin.png') }}" alt="EventAP Logo" class="img-fluid mb-2">
                <h4 class="text-white mb-1">Event & Portfolio Organizer</h4>
                <small class="text-white-50">Admin Panel</small>
                <button class="sidebar-close" id="sidebarClose" aria-label="Close Sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" 
                href="{{ route('admin.events.index') }}">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Users
                </a>
                
                <!-- Logout Section -->
                <div class="sidebar-divider"></div>
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-link logout-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <style>
            /* Sidebar Divider */
            .sidebar-divider {
                height: 1px;
                background: rgba(255,255,255,0.1);
                margin: 1rem 1.5rem;
            }
            
            /* Logout Form Styling */
            .logout-form {
                margin: 0;
            }
            
            .logout-link {
                background: none;
                border: none;
                width: 100%;
                text-align: left;
                color: rgba(255,255,255,0.8);
                padding: 0.875rem 1.5rem;
                border-radius: 8px;
                margin: 0.25rem 1rem;
                transition: var(--transition);
                text-decoration: none;
                display: flex;
                align-items: center;
                font-weight: 500;
                font-size: inherit;
                font-family: inherit;
                cursor: pointer;
            }
            
            .logout-link i {
                width: 20px;
                margin-right: 0.75rem;
            }
            
            .logout-link:hover {
                color: white;
                background: rgba(255,255,255,0.2);
                transform: translateX(5px);
                text-decoration: none;
            }
            
            /* Special styling for logout button to make it look more prominent */
            .logout-link:hover {
                background: rgba(220, 53, 69, 0.2);
                color: #ff6b7a;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            class SidebarController {
                constructor() {
                    this.sidebar = document.getElementById('sidebar');
                    this.toggle = document.getElementById('sidebarToggle');
                    this.close = document.getElementById('sidebarClose');
                    this.overlay = document.getElementById('sidebarOverlay');
                    this.mainContent = document.getElementById('mainContent');
                    this.isMobile = () => window.innerWidth <= 768;
                    
                    this.init();
                }
                
                init() {
                    this.updateUI();
                    this.bindEvents();
                    window.addEventListener('resize', () => this.updateUI());
                    
                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                            e.preventDefault();
                            this.toggleSidebar();
                        }
                        if (e.key === 'Escape' && this.isMobile() && this.isOpen()) {
                            this.closeSidebar();
                        }
                    });
                }
                
                bindEvents() {
                    this.toggle?.addEventListener('click', () => this.toggleSidebar());
                    this.close?.addEventListener('click', () => this.closeSidebar());
                    this.overlay?.addEventListener('click', () => this.closeSidebar());
                    
                    // Auto-close on mobile nav clicks
                    this.sidebar.querySelectorAll('.nav-link').forEach(link => {
                        link.addEventListener('click', () => {
                            if (this.isMobile()) this.closeSidebar();
                        });
                    });
                }
                
                isOpen() {
                    return this.isMobile() ? 
                        this.sidebar.classList.contains('show') : 
                        !this.sidebar.classList.contains('hidden');
                }
                
                toggleSidebar() {
                    this.isOpen() ? this.closeSidebar() : this.openSidebar();
                }
                
                openSidebar() {
                    if (this.isMobile()) {
                        this.sidebar.classList.add('show');
                        this.overlay.classList.add('show');
                        this.toggle.classList.remove('show');
                    } else {
                        this.sidebar.classList.remove('hidden');
                        this.mainContent.classList.remove('expanded');
                        this.toggle.classList.remove('show');
                    }
                }
                
                closeSidebar() {
                    if (this.isMobile()) {
                        this.sidebar.classList.remove('show');
                        this.overlay.classList.remove('show');
                        this.toggle.classList.add('show');
                    } else {
                        this.sidebar.classList.add('hidden');
                        this.mainContent.classList.add('expanded');
                        this.toggle.classList.add('show');
                    }
                }
                
                updateUI() {
                    const wasMobile = this.sidebar.classList.contains('show');
                    
                    if (this.isMobile()) {
                        this.sidebar.classList.remove('hidden');
                        this.mainContent.classList.add('expanded');
                        this.toggle.classList.add('show');
                        
                        if (!wasMobile) {
                            this.sidebar.classList.remove('show');
                            this.overlay.classList.remove('show');
                        }
                    } else {
                        this.sidebar.classList.remove('show');
                        this.overlay.classList.remove('show');
                        this.mainContent.classList.remove('expanded');
                        this.toggle.classList.remove('show');
                    }
                }
            }
            
            document.addEventListener('DOMContentLoaded', () => new SidebarController());
        </script>
        
        @stack('scripts')
    </body>
    </html>