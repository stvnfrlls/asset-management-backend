<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    /**
     * Retrieve all asset types.
     *
     * This function retrieves all asset types from the "AssetType" table and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response The JSON response containing all asset types.
     */
    public function index()
    {
        // Retrieve all asset types from the "AssetType" table.
        $assetTypes = AssetType::select('id', 'assetType_name')->get();

        // Return a JSON response containing all asset types.
        return response(['assetTypes' => $assetTypes], 200);
    }

    /**
     * Store a new asset type.
     *
     * This function creates a new "AssetType" record in the database with the provided asset type name.
     *
     * @param \Illuminate\Http\Request $request The request containing the new asset type name.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "AssetType" model.
        $assetTypes = new AssetType();

        // Set the asset type name from the request data.
        $assetTypes->assetType_name = $request->input('AssetType_Input');

        // Save the new asset type to the database.
        $assetTypes->save();

        // Return a JSON response indicating the successful addition.
        return response(['status' => 200, 'message' => 'Value is added'], 200);
    }

    /**
     * Update an existing asset type.
     *
     * This function updates an existing "AssetType" record in the database with the provided asset type name.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated asset type name.
     * @param int $id The ID of the asset type to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $id)
    {
        // Find the asset type to be updated using the provided $id.
        $update_assetTypes = AssetType::findOrFail($id);

        // Update the asset type name with the data from the request.
        $update_assetTypes->assetType_name = $request->input('AssetType_Input');

        // Save the updated asset type to the database.
        $update_assetTypes->save();

        // Return a JSON response indicating the successful update.
        return response(['status' => 200, 'message' => 'Value is updated'], 200);
    }

    /**
     * Delete an asset type.
     *
     * This function deletes an existing "AssetType" record from the database based on the provided $id.
     *
     * @param int $id The ID of the asset type to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find the asset type to be deleted using the provided $id.
        $delete = AssetType::find($id);

        // If the asset type is found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
