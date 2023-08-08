<?php

// app/Http/Requests/AssetDetailsRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetDetailsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can set this to true if there is no authorization check required for this request.
    }

    public function rules()
    {
        return [
            'excelData.*.Asset No.' => ['required', 'string'],
            'excelData.*.Classification' => ['required', 'string'],
            'excelData.*.Category' => ['required', 'string'],
            'excelData.*.Asset Type' => ['required', 'string'],
            'excelData.*.Manufacturer' => ['required', 'string'],
            'excelData.*.Serial No.' => ['required', 'string'],
            'excelData.*.Model' => ['required', 'string'],
            'excelData.*.Description' => ['required', 'string'],
            'excelData.*.Item Code' => ['required', 'string'],
            'excelData.*.Company' => ['required', 'string'],
            'excelData.*.Supplier' => ['required', 'string'],
            'excelData.*.Amount' => ['required', 'numeric'],
            'excelData.*.Date' => ['required', 'date'],
            'excelData.*.Site' => ['required', 'string'],
            'excelData.*.Area' => ['required', 'string'],
            'excelData.*.Responsible' => ['required', 'string'],
            'excelData.*.Department' => ['required', 'string'],
            'excelData.*.Roles' => ['required', 'string'],
            'excelData.*.Status' => ['required', 'string'],
            'excelData.*.Remarks' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'numeric' => 'The :attribute field must be numeric.',
            'date' => 'The :attribute field must be a valid date.',
            // Add more custom validation messages for specific attributes if needed
        ];
    }
}
