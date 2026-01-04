<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tu Mercado SENA')</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Header Styles */
        .header {
            background: #538392; /* Solid color matching screenshot */
            padding: 0.8rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav {
            gap: 2rem;
            display: flex;
            align-items: center;
        }
        .nav a {
            font-size: 1rem;
            font-weight: 600;
            opacity: 0.9;
            padding: 0;
            background: none !important; /* Remove button style if any */
            color: white;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .nav a:hover {
            opacity: 1;
            text-decoration: underline;
        }
        
        /* User Profile Section in Header */
        .user-profile-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: 20px;
        }
        .chat-icon {
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        .chat-icon:hover {
            opacity: 1;
        }
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            cursor: pointer;
            text-decoration: none !important;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #538392;
            border: 2px solid rgba(255,255,255,0.3);
            overflow: hidden;
        }
        .user-nickname-text {
            font-size: 0.8rem;
            margin-top: 2px;
            font-weight: 600;
            color: white;
        }

        /* Common Main Container Override */
        .main.container {
            margin-top: 20px;
            min-height: calc(100vh - 200px); /* Ensure footer pushes down */
        }
        
        /* Footer Styles */
        .welcome-footer {
            margin-top: 50px;
            padding: 20px 0;
            border-top: 1px solid #eee;
            color: #777;
            text-align: center;
        }

        /* Page specific styles yielded here */
    </style>
    @yield('styles')
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="auth-title" style="margin:0; display: flex; align-items: center;">
                <img src="{{ asset('Logo_azul.png') }}" alt="Logo SENA" class="logo-img" style="filter: brightness(0) invert(1); width: 60px; height: auto; margin-right: 15px;">
                <a href="{{ route('welcome') }}" style="color:white; text-decoration:none; font-size: 1.8rem; font-weight: 800; letter-spacing: 0.5px;">Tu Mercado SENA</a>
            </div>
            
            <nav class="nav">
                <a href="#">Mis Productos</a>
                <a href="{{ route('favorites.index') }}">Favoritos</a>
                <a href="{{ route('products.create') }}">Publicar Producto</a>
                
                <div class="user-profile-section">
                    <!-- Chat Icon -->
                    <div class="chat-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>

                    <!-- User Profile -->
                    <a href="{{ route('profile.index') }}" class="user-info">
                        <div class="user-avatar">
                            @if(Auth::check() && Auth::user()->usuario && Auth::user()->usuario->imagen != 'default.png')
                                <img src="{{ asset('storage/'.Auth::user()->usuario->imagen) }}" alt="Profile" style="width:100%; height:100%; object-fit:cover;">
                            @elseif(Auth::check() && Auth::user()->usuario)
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->usuario->nickname }}&background=random" alt="Profile" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <span class="user-nickname-text">{{ Auth::check() && Auth::user()->usuario ? Auth::user()->usuario->nickname : 'Usuario' }}</span>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="welcome-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Tu Mercado SENA - Todos los derechos reservados</p>
        </div>
    </footer>
    
    @yield('scripts')
</body>
</html>
