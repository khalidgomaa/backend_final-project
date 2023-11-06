<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storePet extends FormRequest
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
            'age' => 'required',
            'type' => 'required',
            'gender' => 'required',
            'image' => 'required|image|mimes:jpeg,png,gif,jpg',
            'price' => 'required',
            'operation' => 'required|in:sell,adopt',
            'user_id' => 'required|exists:users,id',
            'category' => 'required',
        ];
    }
}
