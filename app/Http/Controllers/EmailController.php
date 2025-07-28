<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordEmail;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmailController extends Controller
{
    public function sendResetLink(Request $request)
    {

        $request->validate([
            'correo' => 'required|email',
        ]);

        $user = User::where('correo', $request->correo)->first();
        if (!$user) {
            return response()->json(['message' => 'No se encontró ningún usuario con el correo ' . $request->correo], 404);
        }

        $payload = ['correo' => $user->correo]; 
        $token = JWTAuth::customClaims($payload)->fromUser($user);




        $url = url("http://localhost:5173/reset-password?token={$token}");

        Mail::to($request->correo)->send(new WelcomeMail($url));

        return response()->json(['message' => 'Revisa tu correo']);
    }

    public function reset(Request $request)
    {

        $request->validate([
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            'token' => 'required|string',
        ]);

         try {
            $payload = JWTAuth::setToken($request->token)->getPayload();
            $correo = $payload->get('correo');
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 400, 'message' => 'El token ha expirado'], 400);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 400, 'message' => 'Token inválido'], 400);
        }

        $user = User::where('correo', $correo)->first();
        if (!$user) {
            return response()->json(['message' => 'No se encontró ningún usuario con el correo ' . $correo], 404);
        }

   
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 200, 'message' => 'Contraseña actualizada correctamente']);
    }
}
