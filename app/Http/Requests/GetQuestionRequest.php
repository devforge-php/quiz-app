<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetQuestionRequest extends FormRequest
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
          'categorie_id' => 'required|exists:categories,id', // Kategoriya ID
        'difficultie_id' => 'required|exists:difficulties,id', // Qiyinlik darajasi ID
        'limit' => 'required|integer|min:1', // Savollar soni
        ];
    }
}
