<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Tu Mercado SENA</title>
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
        <div class="auth-box auth-box-lg">
            <h1 class="auth-title">
                <img src="{{ asset('Logo_azul.png') }}" alt="Logo SENA" class="auth-logo">
                Crear Cuenta
            </h1>

            {{-- Mostrar errores --}}
            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}"> <!-- Assuming a POST route will be created later or exists -->
                @csrf
                <div class="form-group form-group-lg">
                    <label for="nickname">Usuario / Nickname</label>
                    <input 
                        type="text" 
                        id="nickname" 
                        name="nickname" 
                        value="{{ old('nickname') }}"
                        required>
                </div>

                <div class="form-group form-group-lg">
                    <label for="email">Correo Institucional (@sena.edu.co)</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required>
                </div>

                <div class="form-group form-group-lg">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group form-group-lg">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-primary btn-lg">Registrarse</button>
            </form>
            <p class="auth-link auth-link-lg"><a href="{{ route('forgot.password') }}">¿Olvidaste tu contraseña?</a></p>
            <p class="auth-link auth-link-lg">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
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
