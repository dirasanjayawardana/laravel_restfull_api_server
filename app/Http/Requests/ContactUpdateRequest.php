<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactUpdateRequest extends FormRequest
{
   // Custom Request (ketika membuat form request yg kompleks, baiknya membuat custom request agar lebih rapi ketika melakukan validasi)
    // membuat custom request: php artisan make:request NamaCustomRequest
    // method rules() --> untuk menambahkan rule untuk validasi
    // untuk menambahkan additional validator setelah validasi, bisa menggunakan method after()
    // jika ingin berhenti melakukan validasi setelah terdapat satu atribute error, bisa menggunakan property $stopOnFirstFailure
    // jika ingin merubah halaman redirect ketika terjadi validation exception, bisa menggunakan property $redirect(URL) atau $redirectRoute(Route)
    // jika ingin menambahkan authentication sebelum melakukan validasi, bisa menggunakan method authorize()
    // untuk mengubah default message, bisa menggunakan method messages()
    // untuk mengubah default nama attribute, bisa menggunakan method attributes()
    // jika ingin melakukan sesuatu sebelum validasi, bisa menggunakan method prepareForValidation()
    // jika ingin melakukan sesuatu setelah validasi, bisa menggunakan method passedValidation()
    // custom response ketika terjadi validation exception, bisa menggunakan failedValidation()


    public function authorize(): bool
    {
        return $this->user() != null;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:100'],
            'last_name' => ['nullable', 'max:100'],
            'email' => ['nullable', 'max:200', 'email'],
            'phone' => ['nullable', 'max:20'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
