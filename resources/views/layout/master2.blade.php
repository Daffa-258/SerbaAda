<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SerbaAda | {{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
        <style>
            html{
                scroll-behavior: smooth;
                
            }
        </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Left: Brand -->
            <a class="navbar-brand" href="#">SerbaAda</a>

            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Center: Navbar links and Right: Icons and Button -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Center: Navbar links -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#category">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#product">Products</a>
                    </li>
    
                    </li>
                </ul>

                <!-- Right: Icons and Button -->
                <div class="d-flex align-items-center">
                    <a href="/cart" class="text-dark me-3">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </a>
                    <a href="/history" class="text-dark me-3">
                        <i class="fas fa-history fa-lg"></i>
                    </a>
                    @auth
                        <a href="/admin/users/{{ auth()->user()->id}}/edit" class="text-dark me-3">
                            <i class="fas fa-user fa-lg"></i> <!-- Icon Profil Person -->
                        </a>
                        @if (auth()->user()->isAdmin == 1)
                        <a class="text-dark me-3" href="/admin/users/" >
                            <i class="fas fa-lg fa-tachometer-alt"></i>
                        </a>             
                        @endif
                    @endauth

                    <a href="/admin/user/create" class="btn btn-primary text-white">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <div class="" style="margin-top: 0;height:100vh;back">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
