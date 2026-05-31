<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo en Caja - Login</title>

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
            </div>

            <form id="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input
                        type="email"
                        id="email"
                        class="form-input"
                        placeholder="correo@email.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        class="form-input"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    Iniciar Sesión
                </button>

                <p id="error-message" class="error-message"></p>
            </form>
        </section>
    </main>
</body>
</html>