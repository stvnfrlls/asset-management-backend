<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Retrieve all departments.
     *
     * This function retrieves all departments from the "Departments" table and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response The JSON response containing all departments.
     */
    public function index()
    {
        // Retrieve all departments from the "Departments" table.
        $departments = Departments::select('id', 'dept_name')->get();

        // Return a JSON response containing all departments.
        return response(['departments' => $departments], 200);
    }

    /**
     * Store a new department.
     *
     * This function creates a new "Departments" record in the database with the provided department name.
     *
     * @param \Illuminate\Http\Request $request The request containing the new department name.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "Departments" model.
        $departments = new Departments();

        // Set the department name from the request data.
        $departments->dept_name = $request->input('Department_Input');

        // Save the new department to the database.
        $departments->save();

        // Return a JSON response indicating the successful addition.
        return response(['status' => 200, 'message' => 'Value is added'], 200);
    }

    /**
     * Update an existing department.
     *
     * This function updates an existing "Departments" record in the database with the provided department name.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated department name.
     * @param int $id The ID of the department to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $id)
    {
        // Find the department to be updated using the provided $id.
        $update_departments = Departments::findOrFail($id);

        // Update the department name with the data from the request.
        $update_departments->dept_name = $request->input('value');

        // Save the updated department to the database.
        $update_departments->save();

        // Return a JSON response indicating the successful update.
        return response(['status' => 200, 'message' => 'Value is updated'], 200);
    }

    /**
     * Delete a department.
     *
     * This function deletes an existing "Departments" record from the database based on the provided $id.
     *
     * @param int $id The ID of the department to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find the department to be deleted using the provided $id.
        $delete = Departments::find($id);

        // If the department is found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
