<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceSpecsRequest extends FormRequest
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
            'storageType' => ['required', 'string'],
            'storageSize' => ['required', 'integer'],
            'memoryType' => ['required', 'string'],
            'memorySize' => ['required', 'integer'],
            'assetID' => ['required', 'integer', 'exists:asset_details,id'],
            'licenseID' => ['required', 'integer', 'exists:licensings,id'],
            'processor' => ['required', 'string'],
            'category' => ['required', 'string', 'exists:categories,category_name'],
            'priorKey' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'storageType.required' => 'The Storage Type field is required.',
            'storageType.string' => 'The Storage Type field must be a string.',
            'storageSize.required' => 'The Storage Size field is required.',
            'storageSize.integer' => 'The Storage Size field must be an integer.',
            'memoryType.required' => 'The Memory Type field is required.',
            'memoryType.string' => 'The Memory Type field must be a string.',
            'memorySize.required' => 'The Memory Size field is required.',
            'memorySize.integer' => 'The Memory Size field must be an integer.',
            'assetID.required' => 'The Asset ID field is required.',
            'assetID.integer' => 'The Asset ID field must be an integer.',
            'assetID.exists' => 'The selected Asset ID is invalid.',
            'licenseID.required' => 'The License ID field is required.',
            'licenseID.integer' => 'The License ID field must be an integer.',
            'licenseID.exists' => 'The selected License ID is invalid.',
            'processor.required' => 'The Processor field is required.',
            'processor.string' => 'The Processor field must be a string.',
            'category.required' => 'The Category field is required.',
            'category.string' => 'The Category field must be a string.',
            'category.exists' => 'The selected Category is invalid.',
            'priorKey.string' => 'The Prior Key field must be a string.',
        ];
    }
}
