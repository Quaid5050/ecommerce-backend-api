<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOAuthRequest extends FormRequest
{
    public function rules()
    {
        return [
            'provider_name' => 'required|string',
            'provider_id' => 'required|string',
            'email' => 'nullable|email',
            'name' => 'required|string|max:255',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
