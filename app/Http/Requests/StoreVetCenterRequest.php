<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreVetCenterRequest extends FormRequest
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
            'name' => ["required", "min:3"],
            'logo' => 'image|mimes:png,jpg,jpeg,gif',
            'license' => 'image|mimes:png,jpg,jpeg,gif',
            'tax_record' => 'image|mimes:png,jpg,jpeg,gif',
            'commercial_record' => 'image|mimes:png,jpg,jpeg,gif',
            'street_address' => 'required|min:5',
            'governorate' => 'required|min:3',
            'about' => 'required|min:20',
            'open_at' => 'required|date_format:h:i A',
            'close_at' => 'required|date_format:h:i A'
        ];
    }
}
