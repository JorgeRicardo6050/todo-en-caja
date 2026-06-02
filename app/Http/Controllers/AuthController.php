<?php

namespace App\Http\Controllers;

use App\Domain\Auth\LoginModel;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private LoginModel $loginModel;

    public function __construct(LoginModel $loginModel)
    {
        $this->loginModel = $loginModel;
    }

    public function mostrarLogin()
    {
        return view('welcome');
    }

    public function mostrarRegistro()
    {
        return view('registro');
    }

    public function registrarCliente(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apepat' => ['required', 'string', 'max:100'],
            'apemat' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $resultado = $this->loginModel->registrarCliente($datos);

        if (! $resultado['ok']) {
            return back()
                ->withErrors([
                    'email' => $resultado['mensaje'],
                ])
                ->withInput();
        }

        return redirect()
            ->route('login')
            ->with('success', $resultado['mensaje']);
    }

    public function iniciarSesion(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $resultado = $this->loginModel->iniciarSesion(
            $credenciales['email'],
            $credenciales['password']
        );

        if (! $resultado['ok']) {
            return back()
                ->withErrors([
                    'email' => $resultado['mensaje'],
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        session($resultado['sesion']);

        return redirect()->route('dashboard');
    }

    public function mostrarDashboard()
    {
        $resultado = $this->loginModel->obtenerDatosDashboard(
            session('tipo_usuario'),
            session('cliente_id'),
            session('empleado_id'),
            session('surtidor_id')
        );

        if (! $resultado['ok']) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => $resultado['mensaje'],
                ]);
        }

        return view('dashboard', $resultado['datos']);
    }

    public function cerrarSesion(Request $request)
    {
        $request->session()->forget([
            'supabase_access_token',
            'supabase_refresh_token',
            'supabase_user',
            'cliente_id',
            'empleado_id',
            'surtidor_id',
            'tipo_usuario',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}