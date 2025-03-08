<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Library Management System') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Custom stylesheet -->
    <style>
        body {
            display: flex;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #074799;
            /* Red background */
            color: white;
            padding: 20px;
            position: fixed;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar.hidden {
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        .sidebar .menu {
            padding: 0;
            margin: 0;
        }

        .sidebar .menu li {
            list-style: none;
            margin: 10px 0;
            display: block;
        }

        .sidebar .menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
        }

        .sidebar .menu li a:hover {
            background: #001A6E;
            /* Darker red */
        }

        .sidebar .menu li a i {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            width: calc(100% - 250px);
            height: 100vh;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }

        .content.full-width {
            margin-left: 0;
            width: 100%;
        }

        .top-menu {
            position: fixed;
            top: 0;
            left: 250px;
            /* Aligns to the right of the sidebar */
            width: calc(100% - 250px);
            height: 50px;
            /* Thinner top menu */
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #074799;
            color: white;
            padding: 0 20px;
            font-size: 16px;
            z-index: 1000;
            transition: left 0.3s ease, width 0.3s ease;
        }

        .top-menu.full-width {
            left: 0;
            width: 100%;
        }

        .top-menu .burger {
            font-size: 20px;
            cursor: pointer;
        }

        .top-menu .user-menu button {
            background: white;
            color: #001A6E;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .top-menu .user-menu .dropdown-menu {
            min-width: 150px;
            text-align: center;
        }

        .content-wrapper {
            margin-top: 50px;
            /* Adjust for fixed top menu */
            height: calc(100vh - 50px);
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo text-center mb-4"> <!-- Added mb-4 for spacing -->
            <a href="#" class="text-white d-flex align-items-center justify-content-center">
                <i class="fas fa-home fa-2x mr-2"></i> <!-- Increased size -->
                <span class="font-weight-bold" style="font-size: 1.8rem;">DEFEMNHS</span> <!-- Bigger text -->
            </a>
        </div>


        <div class="user-menu d-flex align-items-center text-white mt-3"> <!-- Added mt-3 for spacing -->
            <i class="fas fa-user-circle fa-2x mr-2"></i> <!-- Increased icon size -->
            <div class="d-flex flex-column">
                <span class="font-weight-bold">Welcome</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </div>


        <ul class="menu mt-4">
            <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('authors') }}"><i class="fas fa-user-edit"></i> Authors</a></li>
            <li><a href="{{ route('publishers') }}"><i class="fas fa-building"></i> Publishers</a></li>
            <li><a href="{{ route('categories') }}"><i class="fas fa-tags"></i> Categories</a></li>
            <li><a href="{{ route('books') }}"><i class="fas fa-book"></i> Books</a></li>
            <li><a href="{{ route('students') }}"><i class="fas fa-user-graduate"></i> Reg Students</a></li>
            <li><a href="{{ route('book_issued') }}"><i class="fas fa-book-reader"></i> Book Issue</a></li>
            <li><a href="{{ route('reports') }}"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="{{ route('settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </div>

    <!-- Top Menu Bar -->
    <div class="top-menu" id="topMenu">
        <div class="burger" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </div>


        <div class="user-menu">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('change_password') }}">Change Password</a>
                    <a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit()">Log Out</a>
                </div>
                <form method="post" id="logoutForm" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const topMenu = document.getElementById('topMenu');

            sidebar.classList.toggle('hidden');
            content.classList.toggle('full-width');
            topMenu.classList.toggle('full-width');
        });
    </script>
</body>

</html>