<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    // Resource --> Custom Response yang akan dikirimkan

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "name" => $this->name,
        ];
    }


    // custom response jika tidak ingin mengikuti format "data" yg di hasilkan toArray
    // public function withResponse($request, JsonResponse $response)
    // {
    //     $response->setData($this->toArray($request));
    // }
}
