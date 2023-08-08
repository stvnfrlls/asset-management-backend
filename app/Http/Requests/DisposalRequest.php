<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisposalRequest extends FormRequest
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
            'information.responsible' => ['required', 'string', 'max:255'],
            'information.department' => ['required', 'integer'],
            'information.method' => ['required', 'exists:disposal_methods,id'],
            'tradeTo' => ['string', 'max:255'],
            'value' => ['numeric'],
            'assets.*.asset_id' => ['required', 'exists:asset_details,id', 'unique:disposals,asset_id'],
        ];
    }

    public function messages()
    {
        return [
            'information.responsible.required' => 'The responsible field is required.',
            'information.responsible.string' => 'The responsible field must be a string.',
            'information.responsible.max' => 'The responsible field may not be greater than :max characters.',
            'information.department.required' => 'The department field is required.',
            'information.method.required' => 'The method field is required.',
            'information.method.exists' => 'The selected method is invalid.',

            'tradeTo.string' => 'The tradeTo field must be a string.',
            'tradeTo.max' => 'The tradeTo field may not be greater than :max characters.',

            'value.numeric' => 'The value field must be a number.',

            'assets.asset_id.required' => 'The asset_id field is required.',
            'assets.asset_id.exists' => 'The selected asset_id is invalid.',
            'assets.asset_id.unique' => 'The selected asset_id already exist.',
            'assets.reference.string' => 'The reference field must be a string.',
            'assets.reference.max' => 'The reference field may not be greater than :max characters.',
            'assets.description.string' => 'The description field must be a string.',
            'assets.description.max' => 'The description field may not be greater than :max characters.',
            'assets.purpose.string' => 'The purpose field must be a string.',
            'assets.purpose.max' => 'The purpose field may not be greater than :max characters.',
        ];
    }
}
