<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Todo en Caja</title>

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

                <h1 class="login-title">Todo en Caja</h1>
                <p class="login-subtitle">Vista de prueba de sesión iniciada</p>
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de usuario</label>
                <input
                    class="form-input"
                    type="text"
                    value="{{ $tipoUsuario ?? 'Sin tipo' }}"
                    readonly
                >
            </div>

            @if ($cliente)
                <div class="form-group">
                    <label class="form-label">ID Cliente</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $cliente->cte_id }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $cliente->nombre }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Apellido paterno</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $cliente->apepat }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Apellido materno</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $cliente->apemat }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Correo</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $cliente->correo }}"
                        readonly
                    >
                </div>
            @endif

            @if ($empleado)
                <div class="form-group">
                    <label class="form-label">Número de empleado</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $empleado->numempleado }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $empleado->nombre }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Apellido paterno</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $empleado->apepat }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Apellido materno</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $empleado->apemat }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Correo</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $empleado->correo }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Rol</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $empleado->rolEmpleado->rol ?? $empleado->rol ?? 'Sin rol' }}"
                        readonly
                    >
                </div>
            @endif

            @if ($surtidor)
                <div class="form-group">
                    <label class="form-label">ID Surtidor</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $surtidor->surt_id ?? 'Sin ID' }}"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Estante origen</label>
                    <input
                        class="form-input"
                        type="text"
                        value="{{ $surtidor->estante_origen ?? 'Sin estante asignado' }}"
                        readonly
                    >
                </div>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="login-button">
                    Cerrar sesión
                </button>
            </form>
        </section>
    </main>
</body>
</html>