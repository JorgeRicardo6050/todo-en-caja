<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Todo en Caja - Registro</title>

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

                <h1 class="login-title">Registrar Cliente</h1>
                <p class="login-subtitle">Crea una cuenta para comprar en Todo en Caja</p>
            </div>

            <form method="POST" action="{{ route('registro.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-input"
                        placeholder="Ingresa tu nombre"
                        value="{{ old('nombre') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="apepat" class="form-label">Apellido paterno</label>

                    <input
                        type="text"
                        id="apepat"
                        name="apepat"
                        class="form-input"
                        placeholder="Ingresa tu apellido paterno"
                        value="{{ old('apepat') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="apemat" class="form-label">Apellido materno</label>

                    <input
                        type="text"
                        id="apemat"
                        name="apemat"
                        class="form-input"
                        placeholder="Ingresa tu apellido materno"
                        value="{{ old('apemat') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="correo@email.com"
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
                        placeholder="Mínimo 8 caracteres"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Confirma tu contraseña"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    Registrarme
                </button>

                @if ($errors->any())
                    <p class="error-message">
                        {{ $errors->first() }}
                    </p>
                @endif

                <p class="login-subtitle auth-link-text">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}">
                        Inicia sesión
                    </a>
                </p>
            </form>
        </section>
    </main>
</body>
</html>