<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapaControleRegistrosRequest extends FormRequest
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
               
            'codigo' => 'required',
            'responsavel' => 'required',
            'data' => 'required'
    ];
    }
    public function messages()
    {
        return [
            'codigo.required' => 'O código é obrigatório',
            'responsavel.required' => 'o Responsável é obrigatório',
            'data.required' => 'A Data é obrigatória'
        ];
    }
}
