<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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
}
