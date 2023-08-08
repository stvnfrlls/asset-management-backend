<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Classifications;
use Illuminate\Http\Request;

class ClassificationsController extends Controller
{
    /**
     * Retrieve all classifications.
     *
     * This function retrieves all classifications from the "Classifications" table and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response The JSON response containing all classifications.
     */
    public function index()
    {
        // Retrieve all classifications from the "Classifications" table.
        $classifications = Classifications::select('id', 'class_name')->get();

        // Return a JSON response containing all classifications.
        return response(['classifications' => $classifications], 200);
    }

    /**
     * Store a new classification.
     *
     * This function creates a new "Classifications" record in the database with the provided classification name.
     *
     * @param \Illuminate\Http\Request $request The request containing the new classification name.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "Classifications" model.
        $classifications = new Classifications();

        // Set the classification name from the request data.
        $classifications->class_name = $request->input('Classification_Input');

        // Save the new classification to the database.
        $classifications->save();

        // Return a JSON response indicating the successful addition.
        return response(['status' => 200, 'message' => 'Value is added'], 200);
    }

    /**
     * Update an existing classification.
     *
     * This function updates an existing "Classifications" record in the database with the provided classification name.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated classification name.
     * @param int $id The ID of the classification to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $id)
    {
        // Find the classification to be updated using the provided $id.
        $update_classifications = Classifications::findOrFail($id);

        // Update the classification name with the data from the request.
        $update_classifications->class_name = $request->input('value');

        // Save the updated classification to the database.
        $update_classifications->save();

        // Return a JSON response indicating the successful update.
        return response(['status' => 200, 'message' => 'Value is updated'], 200);
    }

    /**
     * Delete a classification.
     *
     * This function deletes an existing "Classifications" record from the database based on the provided $id.
     *
     * @param int $id The ID of the classification to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find the classification to be deleted using the provided $id.
        $delete = Classifications::find($id);

        // If the classification is found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
