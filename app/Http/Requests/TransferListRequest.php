<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferListRequest extends FormRequest
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
            'asset_id' => ['required', 'exists:location_details,id'],
            'from' => ['required', 'string'],
            'site' => ['required', 'string'],
            'area' => ['required', 'string'],
            'responsible' => ['string'],
            'department_id' => ['required'],
            'role_id' => ['required', 'integer'],
            'transferred_date' => ['required', 'date'],
            'status_id' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'asset_id.required' => 'The Asset ID field is required.',
            'asset_id.exists' => 'The selected Asset ID is invalid.',
            'from.required' => 'The From field is required.',
            'from.string' => 'The From field must be a string.',
            'site.required' => 'The Site field is required.',
            'site.string' => 'The Site field must be a string.',
            'area.required' => 'The Area field is required.',
            'area.string' => 'The Area field must be a string.',
            'responsible.string' => 'The Responsible field must be a string.',
            'role_id.required' => 'The Role field is required.',
            'role_id.integer' => 'The Role field must be an integer.',
            'department_id.required' => 'The Department field is required.',
            'transferred_date.required' => 'The Transferred Date field is required.',
            'transferred_date.date' => 'The Transferred Date field must be a valid date.',
            'status_id.required' => 'The Status field is required.',
            'status_id.integer' => 'The Status field must be an integer.',
            // Add more custom validation messages for specific attributes if needed
        ];
    }
}
