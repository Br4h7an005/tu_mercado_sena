<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Tu Mercado SENA</title>
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
                Recuperar Contraseña
            </h1>

            <p class="form-subtitle">Ingresa tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.</p>

            {{-- Mostrar errores --}}
            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success" style="color: #4ade80; background: rgba(74, 222, 128, 0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; text-align: center;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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
                
                <button type="submit" class="btn-primary">Enviar enlace</button>
            </form>
            
            <p class="auth-link">
                <a href="{{ route('login') }}">Volver al inicio de sesión</a>
            </p>
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
