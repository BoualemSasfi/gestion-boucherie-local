<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom_entr'=> 'required|min:1|max:255',
            'N_registre'=> 'required|min:1|max:255',
            'date_registre'=> 'required|min:1|max:255',
            'adresse'=> 'required|min:1|max:255',
            'map'=> 'required|min:1|max:16383',
            'tel'=> 'required|min:1|max:255',
            'email'=> 'required|min:1|max:255',
        ];
    }
}
