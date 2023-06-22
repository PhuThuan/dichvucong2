<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormServiceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string'],
            "model_name" => ['required', 'string'],
            "table_name" => ['required', 'string'],
            "slug" => ['required', 'string'],
            "description" => ['required', 'string'],
            "status" => ['required', 'string'],
        ];
    }
}
