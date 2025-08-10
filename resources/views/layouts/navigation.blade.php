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
                        <a href="{{ route('dashboard', ['department' => $code] + request()->query()) }}" 
                           class="dropdown-item {{ request('department') === $code ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <div class="dept-info">
                                <div class="dept-code">{{ $code }}</div>
                                <div class="dept-name">{{ $name }}</div>
                            </div>
                        </a>
                    @endforeach
                    
                    <div class="dropdown-divider"></div>
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

<script>
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
</script>