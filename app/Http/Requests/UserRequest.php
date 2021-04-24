<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => Rule::requiredIf(function () use ($request) {
                return $request->password != '' ? 'required' : '';
        ];
    }
    public function messages()
    {
        return[
            'name.required' => 'O nome do Usuário e Obrigatório!',
            'email.required' => 'O E-mail do Usuário e Obrigatório!',
            'password.required' => 'A senha do Usuário e Obrigatório!'
        ];
    }
}
