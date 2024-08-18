<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCredentialsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:auth_credentials,email',
            'password' => 'required|min:8',
            'name' => 'required|string|max:255',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
