<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tu Mercado SENA</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<script>
    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
</script>

<body>
    <div class="welcome-wrapper">
        <div class="particles" id="particles"></div>
        <div class="auth-box">
            <h1 class="auth-title">
                <img src="{{ asset('Logo_azul.png') }}" alt="Logo SENA" class="auth-logo">
                Iniciar Sesión
            </h1>

            {{-- Mostrar errores --}}
            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-primary">Iniciar Sesión</button>
                <p class="auth-link"><a href="{{ route('forgot.password') }}">¿Olvidaste tu contraseña?</a></p>
            </form>
            <p class="auth-link">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
            <p class="auth-link"><small>Debes tener un correo @sena.edu.co para registrarte</small></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
        });

        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 15;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                // Tamaño aleatorio
                const size = Math.random() * 6 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Posición inicial aleatoria
                particle.style.left = `${Math.random() * 100}%`;

                // Animación con delay aleatorio
                particle.style.animationDelay = `${Math.random() * 20}s`;
                particle.style.animationDuration = `${15 + Math.random() * 10}s`;

                particlesContainer.appendChild(particle);
            }
        }
    </script>
</body>
</html>