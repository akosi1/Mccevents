<!-- Navigation -->
<nav class="navbar">
    <div class="nav-container">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <i class="fas fa-calendar-alt"></i>
            MCCEvents
        </a>
        
        <!-- Navigation Links -->
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span>Dashboard</span>
            </a>
            
            <div class="nav-dropdown" id="deptDropdown">
                <button class="nav-link dropdown-toggle" onclick="toggleDropdown('deptDropdown')">
                    <span>Departments</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
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
                            {{ $code }} - {{ $name }}
                        </a>
                    @endforeach
                    
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('dashboard', request()->except('department')) }}" class="dropdown-item clear">
                        Clear Filter
                    </a>
                </div>
            </div>
            
            <a href="#" class="nav-link">
                <span>Events</span>
            </a>
            
            <a href="#" class="nav-link">
                <span>About</span>
            </a>
        </div>
        
        <!-- User Menu -->
        <div class="nav-dropdown" id="userDropdown">
            <button class="nav-link user-btn" onclick="toggleDropdown('userDropdown')">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->first_name }}</span>
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
</nav>

<style>
    .navbar {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 2rem;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .nav-brand {
        color: #8b5cf6;
        font-size: 1.75rem;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .nav-brand:hover {
        color: #7c3aed;
        transform: scale(1.05);
        text-decoration: none;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .nav-link {
        position: relative;
        color: #6b7280;
        font-weight: 500;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .nav-link:hover {
        color: #8b5cf6;
        background: rgba(139, 92, 246, 0.05);
        transform: none;
        text-decoration: none;
    }

    .nav-link.active {
        color: #8b5cf6;
        background: none;
        font-weight: 600;
        position: relative;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: #8b5cf6;
        border-radius: 2px 2px 0 0;
    }

    .nav-link.active::before {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #8b5cf6;
    }

    .nav-dropdown {
        position: relative;
    }

    .dropdown-toggle i {
        transition: transform 0.3s ease;
        font-size: 0.8rem;
    }

    .nav-dropdown.show .dropdown-toggle i {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 0.75rem);
        left: 50%;
        transform: translateX(-50%) translateY(-20px) scale(0.9);
        background: white;
        border-radius: 16px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        min-width: 280px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(139, 92, 246, 0.1);
        overflow: hidden;
        z-index: 1000;
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
    }

    .dropdown-menu::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 16px;
        height: 16px;
        background: white;
        border: 1px solid rgba(139, 92, 246, 0.1);
        border-bottom: none;
        border-right: none;
        transform: translateX(-50%) rotate(45deg);
        z-index: -1;
    }

    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0) scale(1);
    }

    .dropdown-menu.right {
        left: auto;
        right: 0;
        transform: translateX(0) translateY(-20px) scale(0.9);
    }

    .dropdown-menu.right::before {
        left: auto;
        right: 20px;
        transform: translateX(0) rotate(45deg);
    }

    .dropdown-menu.right.show {
        transform: translateX(0) translateY(0) scale(1);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-size: 0.9rem;
        position: relative;
        overflow: hidden;
    }

    .dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .dropdown-item:hover::before {
        left: 100%;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(124, 58, 237, 0.1) 100%);
        color: #8b5cf6;
        transform: translateX(8px);
        text-decoration: none;
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover i {
        transform: scale(1.1);
        color: #8b5cf6;
    }

    .dropdown-item.active {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        transform: none;
    }

    .dropdown-item.active::before {
        display: none;
    }

    .dropdown-item.clear {
        color: #f59e0b;
        border-top: 1px solid #f3f4f6;
        margin-top: 0.5rem;
    }

    .dropdown-item.clear:hover {
        color: #d97706;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    }

    .dropdown-item.logout {
        color: #ef4444;
        border-top: 1px solid #f3f4f6;
        margin-top: 0.5rem;
    }

    .dropdown-item.logout:hover {
        color: #dc2626;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
    }

    .dropdown-divider {
        height: 1px;
        background: #f3f4f6;
        margin: 0.5rem 0;
    }

    .user-btn {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white !important;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
    }

    .user-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .user-btn:hover::before {
        left: 100%;
    }

    .user-btn:hover {
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        transform: translateY(-2px);
        color: white !important;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .navbar {
            padding: 1rem;
        }
        
        .nav-container {
            flex-direction: column;
            gap: 1rem;
        }
        
        .nav-links {
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }
        
        .nav-link {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }
</style>

<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        const menu = dropdown.querySelector('.dropdown-menu');
        const button = dropdown.querySelector('.dropdown-toggle, .user-btn');
        const chevron = button.querySelector('.fas.fa-chevron-down');
        const isOpen = menu.classList.contains('show');
        
        // Close all dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
        document.querySelectorAll('.nav-dropdown').forEach(d => d.classList.remove('show'));
        document.querySelectorAll('.fas.fa-chevron-down').forEach(c => c.style.transform = 'rotate(0deg)');
        
        if (!isOpen) {
            menu.classList.add('show');
            dropdown.classList.add('show');
            if (chevron) {
                chevron.style.transform = 'rotate(180deg)';
            }
            
            // Add stagger animation to dropdown items
            const items = menu.querySelectorAll('.dropdown-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 50);
            });
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.nav-dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
            document.querySelectorAll('.nav-dropdown').forEach(d => d.classList.remove('show'));
            document.querySelectorAll('.fas.fa-chevron-down').forEach(c => c.style.transform = 'rotate(0deg)');
        }
    });

    // Add pulse effect to user button on hover
    document.addEventListener('DOMContentLoaded', function() {
        const userBtn = document.querySelector('.user-btn');
        if (userBtn) {
            userBtn.addEventListener('mouseenter', function() {
                this.style.animation = 'pulse 0.6s ease-in-out';
            });
            
            userBtn.addEventListener('mouseleave', function() {
                this.style.animation = '';
            });
        }
    });

    // Add CSS animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1) translateY(0); }
            50% { transform: scale(1.05) translateY(-2px); }
            100% { transform: scale(1) translateY(-2px); }
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .dropdown-menu.show {
            animation: slideInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
    `;
    document.head.appendChild(style);
</script>