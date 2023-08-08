<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetsRequest extends FormRequest
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
            'asset_no' => ['required', 'max:255', 'string'],
            'asset_type' => ['required', 'exists:asset_types,id'],
            'category' => ['required', 'exists:categories,id'],
            'classification' => ['required', 'exists:classifications,id'],
            'manufacturer' => ['required', 'exists:manufacturers,id'],
            'description' => ['max:255'],
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
            'asset_no.required' => 'The asset number field is required.',
            'asset_no.max' => 'The asset number field must not exceed :max characters.',
            'asset_no.string' => 'The asset number field must be a string.',
            'asset_type.required' => 'The asset type field is required.',
            'asset_type.exists' => 'The selected asset type is invalid.',
            'category.required' => 'The category field is required.',
            'category.exists' => 'The selected category is invalid.',
            'classification.required' => 'The classification field is required.',
            'classification.exists' => 'The selected classification is invalid.',
            'manufacturer.required' => 'The manufacturer field is required.',
            'manufacturer.exists' => 'The selected manufacturer is invalid.',
            'description.max' => 'The description field must not exceed :max characters.',
        ];
    }
}
