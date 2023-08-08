<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StatusType;
use Illuminate\Http\Request;

class StatusTypeController extends Controller
{
    public function index()
    {
        // Retrieve all status types from the database, selecting only their 'id' and 'status_name' columns.
        $statusTypes = StatusType::select([
            'id',
            'status_name'
        ])->get();

        // Return the retrieved status types as a JSON response with a status code of 200.
        return response(['statusType' => $statusTypes], 200);
    }

    public function store(Request $request)
    {
        // Create a new instance of the StatusType model.
        $statusType = new StatusType();

        // Set the 'status_name' attribute of the new StatusType instance to the value provided in the 'Status_Input' field of the request.
        $statusType->status_name = $request->input('Status_Input');

        // Save the new StatusType instance to the database.
        $statusType->save();

        // Return a JSON response with a status code of 200 indicating successful creation.
        return response(['status' => 200, 'message' => 'value is added'], 200);
    }

    public function update(Request $request, $id)
    {
        // Find the StatusType model instance with the given $id, or throw an exception if it doesn't exist.
        $update_statusType = StatusType::findOrFail($id);

        // Update the 'status_name' attribute of the found StatusType instance with the value provided in the 'value' field of the request.
        $update_statusType->status_name = $request->input('value');

        // Save the updated StatusType instance to the database.
        $update_statusType->save();

        // Return a JSON response with a status code of 200 indicating the successful update.
        return response(['status' => 200, 'message' => 'value is updated'], 200);
    }

    public function delete($id)
    {
        // Find the StatusType model instance with the given $id, or return null if it doesn't exist.
        $delete = StatusType::find($id);

        // If a StatusType instance was found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
