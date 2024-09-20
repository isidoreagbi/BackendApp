<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Limite à 2Mo
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Le fichier est requis.',
            'file.file' => 'Ce champ doit être un fichier.',
            'file.mimes' => 'Le fichier doit être de type jpg, jpeg, png, ou pdf.',
            'file.max' => 'Le fichier ne doit pas dépasser 2 Mo.',
        ];
    }

}
