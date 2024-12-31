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
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #4a4eb1;
            color: white;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar .nav-link {
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar h2 {
            text-align: center;
        }

        .burger-menu {
            font-size: 1.5rem;
            cursor: pointer;
            position: fixed;
            top: 15px;
            left: 15px;
            color: #4a4eb1;
            z-index: 1100;
            display: none;
        }

        .close-btn {
            font-size: 1.5rem;
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            color: white;
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
        <!-- Close Button -->
        <div class="close-btn" onclick="toggleSidebar()">
            <i class="bi bi-x"></i>
        </div>
        <h2 class="text-white fw-bold mt-5">Jagir Network</h2>
        <i class="text-light mb-4">Follow your passion</i>
        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-house"></i> Home</a>
            <a href="{{ route('profile') }}" class="nav-link"><i class="bi bi-person"></i> Profile</a>
        
           
        </nav>
        <p class="text-light mt-4 text-center">&copy; {{ now()->year }} All rights reserved</p>
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
