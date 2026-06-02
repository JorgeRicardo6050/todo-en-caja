<?php

namespace App\Domain\Auth;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Services\SupabaseAuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class LoginModel
{
    private SupabaseAuthService $supabaseAuthService;

    public function __construct(SupabaseAuthService $supabaseAuthService)
    {
        $this->supabaseAuthService = $supabaseAuthService;
    }

    public function iniciarSesion(string $correo, string $password): array
    {
        $correoNormalizado = strtolower(trim($correo));

        $resultadoAuth = $this->supabaseAuthService->iniciarSesion(
            $correoNormalizado,
            $password
        );

        if (! $resultadoAuth['ok']) {
            return [
                'ok' => false,
                'mensaje' => $resultadoAuth['mensaje'],
                'sesion' => [],
            ];
        }

        $datosAuth = $resultadoAuth['datos'];

        $accessToken = $datosAuth['access_token'] ?? null;
        $refreshToken = $datosAuth['refresh_token'] ?? null;
        $usuarioSupabase = $datosAuth['user'] ?? null;
        $correoSupabase = strtolower(trim($usuarioSupabase['email'] ?? ''));

        if (! $accessToken || ! $correoSupabase) {
            return [
                'ok' => false,
                'mensaje' => 'No se pudo obtener la sesión de Supabase.',
                'sesion' => [],
            ];
        }

        $usuarioSistema = $this->buscarUsuarioEnSistema($correoSupabase, $password);

        if (! $usuarioSistema['ok']) {
            return [
                'ok' => false,
                'mensaje' => $usuarioSistema['mensaje'],
                'sesion' => [],
            ];
        }

        return [
            'ok' => true,
            'mensaje' => 'Inicio de sesión correcto.',
            'sesion' => array_merge([
                'supabase_access_token' => $accessToken,
                'supabase_refresh_token' => $refreshToken,
                'supabase_user' => $usuarioSupabase,
            ], $usuarioSistema['sesion']),
        ];
    }

    public function registrarCliente(array $datos): array
    {
        $correo = strtolower(trim($datos['email']));
        $password = $datos['password'];

        if ($this->buscarClientePorCorreo($correo)) {
            return [
                'ok' => false,
                'mensaje' => 'Este correo ya está registrado como cliente.',
            ];
        }

        $resultadoSupabase = $this->supabaseAuthService->registrarUsuario($correo, $password);

        if (! $resultadoSupabase['ok']) {
            return [
                'ok' => false,
                'mensaje' => $resultadoSupabase['mensaje'],
            ];
        }

        Cliente::create([
            'nombre' => trim($datos['nombre']),
            'apepat' => trim($datos['apepat']),
            'apemat' => trim($datos['apemat'] ?? ''),
            'correo' => $correo,
            'password' => Hash::make($password),
        ]);

        return [
            'ok' => true,
            'mensaje' => 'Cliente registrado correctamente. Ahora puede iniciar sesión.',
        ];
    }

    private function buscarUsuarioEnSistema(string $correo, string $password): array
    {
        $cliente = $this->buscarClientePorCorreo($correo);

        if ($cliente) {
            if (! Hash::check($password, $cliente->password)) {
                return [
                    'ok' => false,
                    'mensaje' => 'La contraseña no coincide con el registro local del cliente.',
                    'sesion' => [],
                ];
            }

            return [
                'ok' => true,
                'mensaje' => 'Cliente encontrado.',
                'sesion' => [
                    'cliente_id' => $cliente->cte_id,
                    'empleado_id' => null,
                    'surtidor_id' => null,
                    'tipo_usuario' => 'cliente',
                ],
            ];
        }

        $empleado = $this->buscarEmpleadoPorCorreo($correo);

        if ($empleado) {
            $tipoUsuario = 'empleado';
            $surtidorId = null;

            $surtidor = $this->buscarSurtidorPorEmpleado($empleado->numempleado);

            if ($surtidor) {
                $tipoUsuario = 'surtidor';
                $surtidorId = $surtidor->surt_id;
            }

            return [
                'ok' => true,
                'mensaje' => 'Empleado encontrado.',
                'sesion' => [
                    'cliente_id' => null,
                    'empleado_id' => $empleado->numempleado,
                    'surtidor_id' => $surtidorId,
                    'tipo_usuario' => $tipoUsuario,
                ],
            ];
        }

        return [
            'ok' => false,
            'mensaje' => 'El usuario existe en Supabase Auth, pero no está registrado como cliente, empleado o surtidor.',
            'sesion' => [],
        ];
    }

    private function buscarClientePorCorreo(string $correo): ?Cliente
    {
        if (! Schema::hasTable('clientes')) {
            return null;
        }

        return Cliente::whereRaw('LOWER(correo) = ?', [$correo])->first();
    }

    private function buscarEmpleadoPorCorreo(string $correo): ?Empleado
    {
        if (! Schema::hasTable('empleados')) {
            return null;
        }

        $consulta = Empleado::whereRaw('LOWER(correo) = ?', [$correo]);

        if (Schema::hasTable('roles')) {
            $consulta->with('rolEmpleado');
        }

        return $consulta->first();
    }

    private function buscarSurtidorPorEmpleado(int $numEmpleado): ?object
    {
        if (! Schema::hasTable('surtidores')) {
            return null;
        }

        return DB::table('surtidores')
            ->where('surt_id', $numEmpleado)
            ->first();
    }

    public function obtenerDatosDashboard(?string $tipoUsuario, $clienteId, $empleadoId, $surtidorId): array
    {
        if (! $tipoUsuario) {
            return [
                'ok' => false,
                'mensaje' => 'No hay una sesión activa.',
                'datos' => [],
            ];
        }

        $cliente = null;
        $empleado = null;
        $surtidor = null;

        if ($tipoUsuario === 'cliente') {
            $cliente = Cliente::find($clienteId);

            if (! $cliente) {
                return [
                    'ok' => false,
                    'mensaje' => 'No se encontró el cliente en la base de datos.',
                    'datos' => [],
                ];
            }
        }

        if ($tipoUsuario === 'empleado' || $tipoUsuario === 'surtidor') {
            $empleado = Empleado::find($empleadoId);

            if (! $empleado) {
                return [
                    'ok' => false,
                    'mensaje' => 'No se encontró el empleado en la base de datos.',
                    'datos' => [],
                ];
            }

            if ($tipoUsuario === 'surtidor' && $surtidorId && Schema::hasTable('surtidores')) {
                $surtidor = DB::table('surtidores')
                    ->where('surt_id', $surtidorId)
                    ->first();
            }
        }

        return [
            'ok' => true,
            'mensaje' => 'Datos recuperados correctamente.',
            'datos' => [
                'tipoUsuario' => ucfirst($tipoUsuario),
                'cliente' => $cliente,
                'empleado' => $empleado,
                'surtidor' => $surtidor,
            ],
        ];
    }
}