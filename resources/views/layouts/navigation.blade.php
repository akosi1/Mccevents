<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventAps Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #2d3748;
        }

        /* Navigation Styles */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Department Dropdown Styles */
        .department-menu {
            position: relative;
            display: inline-block;
        }

        .department-toggle {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .department-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }

        .department-toggle.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .department-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            min-width: 320px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            max-height: 400px;
            overflow-y: auto;
        }

        .department-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .department-item {
            display: block;
            padding: 0.75rem 1rem;
            color: #2d3748;
            text-decoration: none;
            transition: background 0.3s ease;
            border-radius: 8px;
            margin: 0.25rem;
            cursor: pointer;
        }

        .department-item:hover {
            background: #f7fafc;
            color: #667eea;
        }

        .department-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .department-code {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .department-name {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-top: 0.2rem;
        }

        .dropdown-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 0.5rem 0.25rem;
        }

        .clear-filter-item {
            color: #e53e3e !important;
            font-weight: 500;
        }

        .clear-filter-item:hover {
            background: #fed7d7 !important;
            color: #c53030 !important;
        }

        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-toggle {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .user-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            color: #2d3748;
            text-decoration: none;
            transition: background 0.3s ease;
            border-radius: 8px;
            margin: 0.25rem;
        }

        .dropdown-item:hover {
            background: #f7fafc;
            color: #667eea;
        }

        .dropdown-item.logout {
            color: #e53e3e;
            border-top: 1px solid #e2e8f0;
            margin-top: 0.5rem;
            padding-top: 0.75rem;
        }

        /* Dashboard Content */
        .dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: #718096;
            font-size: 1.1rem;
        }

        /* Filter Status Banner */
        .filter-status {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .filter-status.hidden {
            display: none;
        }

        .filter-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Dashboard Content Area */
        .content-area {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            min-height: 400px;
            padding: 2rem;
            text-align: center;
        }

        .content-placeholder {
            color: #718096;
            font-size: 1.1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .dashboard {
                margin: 1rem auto;
                padding: 0 1rem;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }

            .department-dropdown {
                min-width: 280px;
            }

            .filter-status {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-brand">
                <i class="fas fa-calendar-alt"></i> EventAps
            </a>
            
            <div class="nav-links">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <!-- <a href="#" class="nav-link">
                    <i class="fas fa-calendar"></i> Events
                </a> -->
                <!-- <a href="#" class="nav-link">
                    <i class="fas fa-users"></i> Students
                </a> -->
                
                <!-- Department Filter Dropdown -->
                <div class="department-menu">
                    <button class="department-toggle" onclick="toggleDepartmentMenu()" id="departmentToggle">
                        <i class="fas fa-graduation-cap"></i>
                        <span id="departmentLabel">Departments</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="department-dropdown" id="departmentDropdown">
                        <div class="department-item" onclick="filterByDepartment('BSIT')">
                            <div class="department-code">BSIT</div>
                            <div class="department-name">Bachelor of Science in Information Technology</div>
                        </div>
                        <div class="department-item" onclick="filterByDepartment('BSBA')">
                            <div class="department-code">BSBA</div>
                            <div class="department-name">Bachelor of Science in Business Administration</div>
                        </div>
                        <div class="department-item" onclick="filterByDepartment('BSED')">
                            <div class="department-code">BSED</div>
                            <div class="department-name">Bachelor of Science in Education</div>
                        </div>
                        <div class="department-item" onclick="filterByDepartment('BEED')">
                            <div class="department-code">BEED</div>
                            <div class="department-name">Bachelor of Elementary Education</div>
                        </div>
                        <div class="department-item" onclick="filterByDepartment('BSHM')">
                            <div class="department-code">BSHM</div>
                            <div class="department-name">Bachelor of Science in Hospitality Management</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="department-item clear-filter-item" onclick="clearFilter()">
                            <i class="fas fa-times"></i> Clear Filter
                        </div>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="user-menu">
                    <button class="user-toggle" onclick="toggleUserMenu()">
                        <i class="fas fa-user-circle"></i>
                        User
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <!-- <a href="#" class="dropdown-item">
                            <i class="fas fa-cog"></i> Settings
                        </a> -->
                        <a href="#" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>



    <script>
        // Department data
        const DEPARTMENTS = {
            'BSIT': 'Bachelor of Science in Information Technology',
            'BSBA': 'Bachelor of Science in Business Administration',
            'BSED': 'Bachelor of Science in Education',
            'BEED': 'Bachelor of Elementary Education',
            'BSHM': 'Bachelor of Science in Hospitality Management'
        };

        let selectedDepartment = null;

        // Toggle department dropdown
        function toggleDepartmentMenu() {
            const dropdown = document.getElementById('departmentDropdown');
            dropdown.classList.toggle('show');
            
            // Close user dropdown if open
            const userDropdown = document.getElementById('userDropdown');
            userDropdown.classList.remove('show');
        }

        // Toggle user dropdown
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
            
            // Close department dropdown if open
            const departmentDropdown = document.getElementById('departmentDropdown');
            departmentDropdown.classList.remove('show');
        }

        // Close dropdowns when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.department-menu')) {
                const departmentDropdown = document.getElementById('departmentDropdown');
                departmentDropdown.classList.remove('show');
            }
            
            if (!event.target.closest('.user-menu')) {
                const userDropdown = document.getElementById('userDropdown');
                userDropdown.classList.remove('show');
            }
        }

        // Department filter functionality
        function filterByDepartment(deptCode) {
            // Remove active class from all department items
            document.querySelectorAll('.department-item').forEach(item => {
                item.classList.remove('active');
            });

            // Add active class to selected item
            event.target.closest('.department-item').classList.add('active');
            
            // Update selected department
            selectedDepartment = deptCode;
            
            // Update UI elements
            document.getElementById('departmentLabel').textContent = deptCode;
            document.getElementById('departmentToggle').classList.add('active');
            document.getElementById('selectedDept').textContent = deptCode;
            document.getElementById('selectedDeptBanner').textContent = `${deptCode} - ${DEPARTMENTS[deptCode]}`;
            
            // Show filter status banner
            document.getElementById('filterStatus').classList.remove('hidden');
            
            // Close dropdown
            document.getElementById('departmentDropdown').classList.remove('show');

            // Here you would typically make an AJAX call to filter content
            console.log('Filtering by department:', deptCode);
        }

        function clearFilter() {
            // Remove active class from all department items
            document.querySelectorAll('.department-item').forEach(item => {
                item.classList.remove('active');
            });

            // Reset selected department
            selectedDepartment = null;
            
            // Update UI elements
            document.getElementById('departmentLabel').textContent = 'Departments';
            document.getElementById('departmentToggle').classList.remove('active');
            document.getElementById('selectedDept').textContent = 'All Departments';
            
            // Hide filter status banner
            document.getElementById('filterStatus').classList.add('hidden');
            
            // Close dropdown
            document.getElementById('departmentDropdown').classList.remove('show');

            // Here you would typically make an AJAX call to show all content
            console.log('Filter cleared');
        }
    </script>
</body>
</html>