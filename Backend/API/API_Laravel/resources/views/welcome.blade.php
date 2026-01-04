<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Tu Mercado SENA</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <div class="welcome-wrapper">
        <!-- Partículas animadas -->
        <div class="particles" id="particles"></div>

        <div class="welcome-container">
            <!-- Sección Hero (izquierda) -->
            <div class="welcome-hero">
                <div class="hero-content">
                    <!-- Logo implementado con Laravel asset() -->
                    <img src="{{ asset('logo.png') }}" alt="Tu Mercado SENA" class="welcome-logo">
                    <h1 class="hero-title">Tu Mercado SENA</h1>
                    <p class="hero-subtitle">
                        La plataforma exclusiva para la comunidad SENA. Compra, vende y conecta de forma segura con aprendices e instructores.
                    </p>

                    <div class="hero-features">
                        <div class="feature">
                            <div class="feature-icon">🛒</div>
                            <span>Compra productos de calidad</span>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">💰</div>
                            <span>Vende lo que ya no uses</span>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">💬</div>
                            <span>Chat seguro integrado</span>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">🔒</div>
                            <span>Comunidad verificada SENA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Formulario (derecha) -->
            <div class="welcome-form-section">
                <h2 class="form-title">¡Bienvenido!</h2>
                <p class="form-subtitle">Únete a nuestra comunidad</p>

                <div class="welcome-buttons">
                    <a href="{{ route('login') }}" class="btn-welcome btn-welcome-login">
    Iniciar Sesión
</a>
                    <a href="{{ route('register') }}" class="btn-welcome btn-welcome-register">
                        Crear Cuenta
                    </a>
                </div>

                <div class="welcome-footer">
                    <p>💡 <strong>Exclusivo para la comunidad SENA</strong></p>
                    <div class="sena-badge">
                        <span>🏫</span>
                        Requiere correo @sena.edu.co
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Forzar modo claro en welcome
        document.addEventListener('DOMContentLoaded', function() {
            localStorage.setItem('theme', 'light');
            document.documentElement.setAttribute('data-theme', 'light');

            // Crear partículas animadas
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