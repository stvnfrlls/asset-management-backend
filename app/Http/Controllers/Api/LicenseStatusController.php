<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\LicenseStatus;
use Illuminate\Http\Request;

class LicenseStatusController extends Controller
{
    /**
     * Display a listing of the license status.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all license statuses from the database
        $licenseStatus = LicenseStatus::select(
            'id',
            'status'
        )
            ->get();

        // Return the license statuses as a response with HTTP status code 200 (OK)
        return response(['license_status' => $licenseStatus], 200);
    }

    /**
     * Store a newly created license status in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new instance of LicenseStatus model
        $licenseStatus = new LicenseStatus();

        // Assign the 'status' attribute of the new LicenseStatus object
        // with the input value from the request (LicenseStatus_Input)
        $licenseStatus->status = $request->input('LicenseStatus_Input');

        // Save the new LicenseStatus object to the database
        $licenseStatus->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'value is added'], 200);
    }

    /**
     * Update the specified license status in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the LicenseStatus object with the given $id in the database
        $update_licenseStatus = LicenseStatus::findOrFail($id);

        // Update the 'status' attribute of the LicenseStatus object
        // with the new value from the request (value)
        $update_licenseStatus->status = $request->input('value');

        // Save the updated LicenseStatus object to the database
        $update_licenseStatus->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'value is updated'], 200);
    }

    /**
     * Remove the specified license status from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Find the LicenseStatus object with the given $id in the database
        $delete = LicenseStatus::find($id);

        // If the LicenseStatus object is found, delete it from the database
        if ($delete) {
            $delete->delete();
        }

        // Note: There is no response returned for deletion, so the client will not receive any feedback.
    }
}
