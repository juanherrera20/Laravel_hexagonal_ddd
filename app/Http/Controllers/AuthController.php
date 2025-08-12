<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Logica de Autenticación

    private $registerValidationRules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required'
    ];

    // Register logic
    public function registerUser(Request $request)
    {
        try {
            // Validación
            $validateUser = Validator::make($request->all(), $this->registerValidationRules);

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => 'Ha ocurrido un error de validación',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            // Creación de usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Respuesta de éxito
            return response()->json([
                'message' => 'El usuario se ha creado',
                'token' => $user->createToken("API ACCESS TOKEN")->plainTextToken
            ], 200);

        } catch (\Exception $e) {
            // Captura de cualquier error
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage() 
            ], 500);
        }
    }


    // Login Logic
    public function loginUser (Request $request) {
        try {
            $validateLogin = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validateLogin->fails()){
                return response()->json([
                    'message' => 'Ha ocurrido un error de validación',
                    'errors' => $validateLogin->errors()
                ], 400);
            }

            $credentials = $validateLogin->validated();
            // print_r($credentials);

            if (Auth::attempt($credentials)) 
            {
                $user = Auth::user();

                return response()->json([
                    'message' => 'Login Exitoso',
                    'token' => $user->createToken("API ACCESS TOKEN")->plainTextToken
                ], 200);

            } else 
            {
                return response()->json([
                    'message' => 'El email y el password no corresponden con alguno de los usuarios',
                ], 401);
            };
            
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Error Interno del Servidor',
                'error' => $e -> getMessage()
            ]);

        }
        
    }

    public function logoutUser (Request $request) {

        $user = Auth::user();

        $user -> tokens() -> delete();


        return response() -> json([
            'message' => 'El Usuario ha Cerrado Sesión de Manera Exitosa'
        ], 200);
    }
}


