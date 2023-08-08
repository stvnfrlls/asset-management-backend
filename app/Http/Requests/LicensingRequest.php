<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicensingRequest extends FormRequest
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
            'category' => ['required', 'exists:categories,id'],
            'software' => ['required', 'max:255', 'string'],
            'version' => ['required', 'max:255', 'string'],
            'license_key' => ['required', 'max:255', 'string'],
            'status' => ['required', 'exists:license_statuses,id'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'category.required' => 'The category field is required.',
            'category.exists' => 'The selected category is invalid.',
            'software.required' => 'The operating system field is required.',
            'software.max' => 'The operating system field must not exceed :max characters.',
            'version.required' => 'The version field is required.',
            'version.max' => 'The version field must not exceed :max characters.',
            'license_key.required' => 'The license key field is required.',
            'license_key.max' => 'The license key field must not exceed :max characters.',
            'status.required' => 'The status field is required.',
            'status.exists' => 'The selected status is invalid.',
        ];
    }
}
