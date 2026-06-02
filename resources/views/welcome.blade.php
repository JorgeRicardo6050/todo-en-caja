<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Todo en Caja - Login</title>

    <link rel="icon" type="image/png" href="{{ Vite::asset('resources/imagenes/logocaja.png') }}">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body>
    <main class="login-container">
        <section class="login-card">
            <div class="login-header">
                <div class="icon-box">
                    <img
                        src="{{ Vite::asset('resources/imagenes/logocaja.png') }}"
                        alt="Logo Todo en Caja"
                        class="login-logo"
                    >
                </div>

                <h1 class="login-title">Iniciar Sesión</h1>
                <p class="login-subtitle">Ingresa tus credenciales</p>
            </div>

            <form id="login-form" method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="correo@email.com"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    Iniciar Sesión
                </button>

                @if ($errors->any())
                    <p class="error-message">
                        {{ $errors->first() }}
                    </p>
                @endif

                @if (session('success'))
                    <p class="success-message">
                        {{ session('success') }}
                    </p>
                @endif

                <p class="login-subtitle auth-link-text">
                    ¿No tienes cuenta?
                    <a href="{{ route('registro') }}">
                        Regístrate
                    </a>
                </p>
            </form>
        </section>
    </main>
</body>
</html>