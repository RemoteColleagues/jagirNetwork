<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: white;
            color: black;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 3px solid #007bff;
        }

        .sidebar .logo-section {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
        }

        .sidebar .logo-section h2 {
            font-size: 1.8rem;
            color: black;
        }

        .sidebar .logo-section i {
            font-size: 1rem;
            color: #666;
        }

        .sidebar .nav-link {
            padding: 15px;
            color: black;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 8px 10px;
            font-size: 1.1rem;
            border: 2px solid #007bff;
        }

        .sidebar .nav-link:hover {
            background-color: #007bff;
            transform: translateX(5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
        }

        .sidebar h2 img {
            max-width: 94%;
            max-height: 140px;
            object-fit: contain;
        }

        .burger-menu {
            font-size: 1.5rem;
            cursor: pointer;
            position: fixed;
            top: 15px;
            left: 15px;
            color: #007bff;
            z-index: 1100;
            display: none;
        }

        .close-btn {
            font-size: 1.5rem;
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            color: #007bff;
            display: none;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed {
            left: -250px;
        }

        .content.collapsed {
            margin-left: 0;
        }

        .sidebar .footer {
            margin-top: auto;
            text-align: center;
            padding: 15px;
            background-color: #007bff;
            color: white;
        }

        @media (max-width: 768px) {
            .burger-menu {
                display: block;
            }

            .close-btn {
                display: block;
            }

            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .content.shifted {
                margin-left: 250px;
            }
        }
    </style>
</head>

<body>
    <!-- Burger Menu -->
    <div class="burger-menu" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Logo Section -->
        <div class="logo-section">
            <h2>
                <img src="{{ asset('logo.png') }}" alt="Company Logo">
            </h2>
            <i class="text-muted mb-4">Follow your passion</i>
        </div>

        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-house"></i> Home</a>
            <a href="{{ route('profile') }}" class="nav-link"><i class="bi bi-person"></i> Profile</a>
            @if (auth()->user() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.index') }}" class="nav-link"><i class="bi bi-people"></i> Users</a>
        @endif
        
            <form action="{{ route('user.logout') }}" method="POST" class="nav-link" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-danger" style="text-decoration: none;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        
        </nav>

        <!-- Footer -->
        <div class="footer">
            <p class="text-light mt-4">&copy; {{ now()->year }} All rights reserved</p>
        </div>
    </div>

    <!-- Content -->
    <div class="content" id="content">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
                content.classList.toggle('shifted');
            } else {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');
            }
        }
    </script>
</body>

</html>
