<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SupabaseAuthService
{
    public function iniciarSesion(string $correo, string $password): array
    {
        $supabaseUrl = config('services.supabase.url');
        $supabaseKey = config('services.supabase.publishable_key');

        try {
            $response = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
            ])->post($supabaseUrl . '/auth/v1/token?grant_type=password', [
                'email' => $correo,
                'password' => $password,
            ]);
        } catch (ConnectionException $e) {
            return [
                'ok' => false,
                'mensaje' => 'No se pudo conectar con Supabase. Revisa tu conexión o reinicia Docker.',
                'datos' => null,
            ];
        }

        if (! $response->successful()) {
            $error = $response->json();

            return [
                'ok' => false,
                'mensaje' => $error['msg'] ?? $error['message'] ?? 'Correo o contraseña incorrectos.',
                'datos' => $error,
            ];
        }

        return [
            'ok' => true,
            'mensaje' => 'Autenticación correcta.',
            'datos' => $response->json(),
        ];
    }

    public function registrarUsuario(string $correo, string $password): array
    {
        $supabaseUrl = config('services.supabase.url');
        $supabaseKey = config('services.supabase.publishable_key');

        try {
            $response = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
            ])->post($supabaseUrl . '/auth/v1/signup', [
                'email' => $correo,
                'password' => $password,
            ]);
        } catch (ConnectionException $e) {
            return [
                'ok' => false,
                'mensaje' => 'No se pudo conectar con Supabase. Revisa tu conexión o reinicia Docker.',
                'datos' => null,
            ];
        }

        if (! $response->successful()) {
            $error = $response->json();

            return [
                'ok' => false,
                'mensaje' => $error['msg'] ?? $error['message'] ?? 'No se pudo registrar el usuario en Supabase.',
                'datos' => $error,
            ];
        }

        return [
            'ok' => true,
            'mensaje' => 'Usuario registrado correctamente en Supabase.',
            'datos' => $response->json(),
        ];
    }
}