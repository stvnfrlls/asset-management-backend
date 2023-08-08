<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Components;
use Illuminate\Http\Request;

class ComponentsController extends Controller
{
    /**
     * Retrieve all components.
     *
     * This function retrieves all components from the "Components" table and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response The JSON response containing all components.
     */
    public function index()
    {
        // Retrieve all components from the "Components" table.
        $components = Components::select(
            'id',
            'storage_type',
            'storage_size',
            'memory_type',
            'memory_size'
        )->get();

        // Return a JSON response containing all components.
        return response(['components' => $components], 200);
    }

    /**
     * Store a new component.
     *
     * This function creates a new "Components" record in the database with the provided component information.
     *
     * @param \Illuminate\Http\Request $request The request containing the new component information.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "Components" model.
        $components = new Components();

        // Set the component information from the request data.
        $components->storage_type = $request->input('storage_type');
        $components->storage_size = $request->input('storage_size');
        $components->memory_type = $request->input('memory_type');
        $components->memory_size = $request->input('memory_size');

        // Save the new component to the database.
        $components->save();

        // Return a JSON response indicating the successful addition.
        return response(['status' => 200, 'message' => 'Component Saved'], 200);
    }

    /**
     * Retrieve a specific component.
     *
     * This function retrieves a specific component from the "Components" table based on the provided $component_id.
     *
     * @param int $component_id The ID of the component to be retrieved.
     * @return \Illuminate\Http\Response The JSON response containing the specific component.
     */
    public function show($component_id)
    {
        // Retrieve the specific component from the "Components" table using the provided $component_id.
        $components = Components::select(
            'id',
            'storage_type',
            'storage_size',
            'memory_type',
            'memory_size'
        )
            ->where('id', $component_id)
            ->get();

        // Return a JSON response containing the specific component.
        return response(['components' => $components], 200);
    }

    /**
     * Update an existing component.
     *
     * This function updates an existing "Components" record in the database with the provided component information.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated component information.
     * @param int $component_id The ID of the component to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $component_id)
    {
        // Find the component to be updated using the provided $component_id.
        $update_component = Components::findOrFail($component_id);

        // Update the component information with the data from the request.
        $update_component->storage_type = $request->input('storage_type');
        $update_component->storage_size = $request->input('storage_size');
        $update_component->memory_type = $request->input('memory_type');
        $update_component->memory_size = $request->input('memory_size');

        // Save the updated component to the database.
        $update_component->save();

        // Return a JSON response indicating the successful update.
        return response(['status' => 200, 'message' => 'Component is updated'], 200);
    }

    /**
     * Delete a component.
     *
     * This function deletes an existing "Components" record from the database based on the provided $id.
     *
     * @param int $id The ID of the component to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find the component to be deleted using the provided $id.
        $delete = Components::find($id);

        // If the component is found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
