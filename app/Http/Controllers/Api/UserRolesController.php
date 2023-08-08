<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    /**
     * Display a listing of all user roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all user roles from the database
        $roles = UserRoles::select([
            'id',
            'role'
        ])->get();

        // Return the user roles as a response with HTTP status code 200 (OK)
        return response(['roles' => $roles], 200);
    }

    /**
     * Store a newly created user role in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new instance of UserRoles model
        $userRoles = new UserRoles();

        // Assign the 'role' attribute of the new UserRoles object
        // with the input value from the request (Roles_Input)
        $userRoles->role = $request->input('Roles_Input');

        // Save the new UserRoles object to the database
        $userRoles->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'value is added'], 200);
    }

    /**
     * Update the specified user role in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the UserRoles object with the given $id in the database
        $update_userRoles = UserRoles::findOrFail($id);

        // Update the 'role' attribute of the UserRoles object
        // with the new value from the request (value)
        $update_userRoles->role = $request->input('value');

        // Save the updated UserRoles object to the database
        $update_userRoles->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'value is updated'], 200);
    }

    /**
     * Remove the specified user role from the database.
     *
     * @param  int  $id
     * @return void
     */
    public function delete($id)
    {
        // Find the UserRoles object with the given $id in the database
        $delete = UserRoles::find($id);

        // If the UserRoles object is found, delete it from the database
        if ($delete) {
            $delete->delete();
        }

        // Note: There is no response returned for deletion, so the client will not receive any feedback.
    }
}
