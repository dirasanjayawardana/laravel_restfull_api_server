<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // untuk api registrasikan route nya di routes/api.php, bukan di routes/web.php
    // menggunakan custom response dan custom request


    public function register(UserRegisterRequest $request): JsonResponse
    {
        // mengambil data yang selesai di validasi di custom request
        $data = $request->validated();

        // cek apakah username sudah terdaftar
        if (User::where("username", "=", $data['username'])->count() == 1) {
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ], 400));
        }

        // buar user baru dan simpan
        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        // return response
        return (new UserResource($user))->response()->setStatusCode(201);
    }


    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }


    public function get(Request $request): UserResource
    {
        // mengambil user yg sedang login, yang sudah diregistrasikan di middleware ApiAuthMiddleware
        $user = Auth::user();

        return new UserResource($user);
    }


    public function update(UserUpdateRequest $request): UserResource
    {
        $data = $request->validated();
        $user = Auth::user();

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return new UserResource($user);
    }


    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response()->json([
            "data"=> true
        ])->setStatusCode(200);
    }
}
