<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Este middleware verifica que el usuario esté autenticado en todas las rutas excepto en las de 'login' y 'register'
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // Este método verifica si el usuario autenticado es un administrador
    static public function isAdmin()
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            return false;
        }
        return true;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        // Obtiene las credenciales del usuario (correo electrónico y contraseña)
        $credentials = request(['email', 'password']);

        // Verifica si las credenciales son correctas y, si no lo son, devuelve un error
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Devuelve un token JWT si las credenciales son correctas
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // Devuelve información sobre el usuario autenticado
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Invalida el token de autenticación actual y cierra la sesión del usuario
        auth()->logout();

        // Devuelve un mensaje de éxito
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Este método registra un nuevo usuario
    public function register()
    {
        try {
            // Valida los datos del formulario de registro
            $this->validate(request(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed',
                'role' => 'required|string'
            ]);
        } catch (\Exception $e) {
            // Devuelve un error si la validación falla
            return response()->json(['error' => $e->getMessage()], 401);
        }

        // Crea un array con las credenciales del usuario
        $credentials = request(['name', 'email', 'password', 'role']);

        // Hashea la contraseña del usuario
        $credentials['password'] = bcrypt($credentials['password']);

        try {
            // Crea un nuevo usuario con las credenciales especificadas
            $user = User::create($credentials);
        } catch (\Exception $e) {
            // Devuelve un error si la creación del usuario falla
            return response()->json(['error' => $e->getMessage()], 401);
        }

        // Autentica al nuevo usuario y devuelve un token JWT
        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // Se refresca el token.
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        // Se devuelve una respuesta JSON con la estructura del token.
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // tiempo de vida del token en minutos.
        ]);
    }
}
