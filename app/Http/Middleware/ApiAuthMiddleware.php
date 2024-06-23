<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    // middleware untuk cek token apakah sudah login
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $authenticate = true;

        if (!$token) {
            $authenticate = false;
        }

        $user = User::where('token', '=', $token)->first();
        if (!$user) {
            $authenticate = false;
        } else {
            // meregistrasikan user ke dalam session, model User harus implementasi Authenticatable
            // jika sudah disimpan di session, ketika butuh data user, bisa dengan: Auth::user()
            Auth::login($user);
        }


        if ($authenticate) {
            return $next($request);
        } else {
            return response()->json([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ])->setStatusCode(401);
        }
    }
}
