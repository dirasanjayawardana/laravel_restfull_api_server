<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // untuk api registrasikan route nya di routes/api.php, bukan di routes/web.php

    // menggunakan custom response dan custom request


    public function create(CreateContactRequest $request): JsonResponse
    {
        $data = $request->validated(); // mengambil data yang selesai di validasi di custom request
        $user = Auth::user(); // mengambil data user yg sudah login di session, yg telah disimpan di middleware

        $contact = new Contact($data);
        $contact->user_id = $user->id;
        $contact->save();

        return (new ContactResource($contact))->response()->setStatusCode(201);
    }
}
