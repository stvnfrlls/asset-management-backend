<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DisposalMethod;
use Illuminate\Http\Request;

class DisposalMethodController extends Controller
{

    /**
     * Retrieve disposal methods.
     *
     * This function retrieves the available disposal methods from the "DisposalMethod" table.
     *
     * @return \Illuminate\Http\Response The JSON response containing the disposal methods.
     */
    public function index()
    {
        // Retrieve disposal methods from the "DisposalMethod" table.
        $disposalMethod = DisposalMethod::select(
            'id',
            'method'
        )
            ->get();

        // Return a JSON response containing the disposal methods.
        return response(['disposal_method' => $disposalMethod], 200);
    }

    /**
     * Store a disposal method.
     *
     * This function stores a new disposal method into the "DisposalMethod" table.
     *
     * @param \Illuminate\Http\Request $request The request containing the disposal method information.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "DisposalMethod" model and save the disposal method information.
        $disposalMethod = new DisposalMethod();
        $disposalMethod->method = $request->input('DisposalMethod_Input');
        $disposalMethod->save();

        // Return a JSON response indicating the successful addition of the disposal method.
        return response(['status' => 200, 'message' => 'Value is added'], 200);
    }

    /**
     * Update a disposal method.
     *
     * This function updates the information of an existing disposal method in the "DisposalMethod" table.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated disposal method information.
     * @param int $id The ID of the disposal method to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $id)
    {
        // Find the disposal method with the given ID or fail if not found.
        $update_disposalMethod = DisposalMethod::findOrFail($id);

        // Update the method field with the new value from the request.
        $update_disposalMethod->method = $request->input('value');
        $update_disposalMethod->save();

        // Return a JSON response indicating the successful update of the disposal method.
        return response(['status' => 200, 'message' => 'Value is updated'], 200);
    }

    /**
     * Delete a disposal method.
     *
     * This function deletes a disposal method record from the "DisposalMethod" table.
     *
     * @param int $id The ID of the disposal method to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find and delete the disposal method record with the given ID from the "DisposalMethod" table.
        $delete = DisposalMethod::find($id);
        if ($delete) {
            $delete->delete();
        }
    }
}
