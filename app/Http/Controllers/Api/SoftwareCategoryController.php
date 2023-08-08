<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SoftwareCategory;
use Illuminate\Http\Request;

class SoftwareCategoryController extends Controller
{
    public function index()
    {
        // Retrieve all software categories from the database, selecting only their 'id' and 'software_category' columns.
        $softwareCategories = SoftwareCategory::select(
            'id',
            'software_category'
        )->get();

        // Return the retrieved software categories as a JSON response with a status code of 200.
        return response(['software_category' => $softwareCategories], 200);
    }

    public function store(Request $request)
    {
        // Create a new instance of the SoftwareCategory model.
        $softwareCategory = new SoftwareCategory();

        // Set the 'software_category' attribute of the new SoftwareCategory instance to the value provided in the 'Software_Input' field of the request.
        $softwareCategory->software_category = $request->input('Software_Input');

        // Save the new SoftwareCategory instance to the database.
        $softwareCategory->save();

        // Return a JSON response with a status code of 200 indicating successful creation.
        return response(['status' => 200, 'message' => 'value is added'], 200);
    }

    public function update(Request $request, $id)
    {
        // Find the SoftwareCategory model instance with the given $id, or throw an exception if it doesn't exist.
        $update_softwareCategory = SoftwareCategory::findOrFail($id);

        // Update the 'software_category' attribute of the found SoftwareCategory instance with the value provided in the 'value' field of the request.
        $update_softwareCategory->software_category = $request->input('value');

        // Save the updated SoftwareCategory instance to the database.
        $update_softwareCategory->save();

        // Return a JSON response with a status code of 200 indicating the successful update.
        return response(['status' => 200, 'message' => 'value is updated'], 200);
    }

    public function delete($id)
    {
        // Find the SoftwareCategory model instance with the given $id, or return null if it doesn't exist.
        $delete = SoftwareCategory::find($id);

        // If a SoftwareCategory instance was found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
