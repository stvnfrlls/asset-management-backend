<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LicensingRequest;
use App\Models\Licensing;

class LicensingController extends Controller
{
    /**
     * Display a listing of all licenses with additional information (category, software, version, etc.).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all licenses along with related information from the database
        $stored_licenses = Licensing::select(
            'licensings.id',
            'software_categories.software_category as category',
            'software',
            'version',
            'license_key',
            'license_statuses.status as status'
        )
            ->join('software_categories', 'licensings.category', '=', 'software_categories.id')
            ->join('license_statuses', 'license_statuses.id', '=', 'licensings.status')
            ->orderBy('licensings.updated_at', 'desc')
            ->get();

        // Count the total number of licenses in the database
        $countLicenses = Licensing::count();

        // Count the number of licenses available (status = 1) in the database
        $countLicenseAvailable = Licensing::where('status', '=', "1")->count();

        // Count the number of licenses in use (status = 2) in the database
        $countLicenseInUse = Licensing::where('status', '=', "2")->count();

        // Count the number of expired licenses (status = 3) in the database
        $countLicenseExpired = Licensing::where('status', '=', "3")->count();

        // Return the licenses data and counts as a response with HTTP status code 200 (OK)
        return response([
            'status' => 200,
            'Licenses' => $stored_licenses,
            'LicenseCount' => $countLicenses,
            'LicenseAvailable' => $countLicenseAvailable,
            'LicenseInUse' => $countLicenseInUse,
            'LicenseExpired' => $countLicenseExpired
        ], 200);
    }

    /**
     * Display a listing of licenses that are available for a specific operating system (category = 1 and status = 1).
     *
     * @return \Illuminate\Http\Response
     */
    public function availableOperatingSystem()
    {
        // Retrieve licenses that belong to the category with id = 1 (Operating System) and have status = 1 (Available)
        $available_OS = Licensing::select(
            'licensings.id',
            'software_categories.software_category as category',
            'software',
            'version',
            'license_key',
            'license_statuses.status as status'
        )
            ->where('licensings.category', '=', '1')
            ->where('license_statuses.id', '=', '1')
            ->join('software_categories', 'licensings.category', '=', 'software_categories.id')
            ->join('license_statuses', 'license_statuses.id', '=', 'licensings.status')
            ->get();

        // Return the available licenses for the specified operating system as a response with HTTP status code 200 (OK)
        return response(['available_OS' => $available_OS], 200);
    }

    /**
     * Store a newly created license in the database.
     *
     * @param  \App\Http\Requests\LicensingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LicensingRequest $request)
    {
        // Create a new LicenseStatus object and store it in the database
        Licensing::create($request->only([
            'category',
            'software',
            'version',
            'license_key',
            'status'
        ]));

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'Software License Saved'], 200);
    }

    /**
     * Display the specified license details.
     *
     * @param  int  $license_id
     * @return \Illuminate\Http\Response
     */
    public function show($license_id)
    {
        // Retrieve the details of the license with the given $license_id from the database
        $license = Licensing::select(
            'category',
            'software',
            'version',
            'license_key',
            'status',
        )
            ->where('id', $license_id)
            ->get();

        // Return the license details as a response with HTTP status code 200 (OK)
        return response(['License_Details' => $license], 200);
    }

    /**
     * Update the specified license in the database.
     *
     * @param  \App\Http\Requests\LicensingRequest  $request
     * @param  int  $license_id
     * @return \Illuminate\Http\Response
     */
    public function update(LicensingRequest $request, $license_id)
    {
        // Find the LicenseStatus object with the given $license_id in the database
        $update_license = Licensing::findOrFail($license_id);

        // Update the attributes of the LicenseStatus object with new values from the request
        $update_license->category = $request->input('category');
        $update_license->software = $request->input('software');
        $update_license->version = $request->input('version');
        $update_license->license_key = $request->input('license_key');
        $update_license->status = $request->input('status');

        // Save the updated LicenseStatus object to the database
        $update_license->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['message' => 'License details are updated'], 200);
    }

    /**
     * Remove the specified license from the database.
     *
     * @param  int  $id
     * @return void
     */
    public function delete($id)
    {
        // Find the LicenseStatus object with the given $id in the database
        $delete = Licensing::find($id);

        // If the LicenseStatus object is found, delete it from the database
        if ($delete) {
            $delete->delete();
        }

        // Note: There is no response returned for deletion, so the client will not receive any feedback.
    }
}
