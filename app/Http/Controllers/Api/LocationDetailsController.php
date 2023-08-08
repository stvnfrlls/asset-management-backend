<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationDetails;
use Illuminate\Http\Request;

class LocationDetailsController extends Controller
{
    /**
     * Display a listing of all location details for assets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all location details with additional information (asset details) from the database
        $location = LocationDetails::select(
            'location_details.id',
            'asset_details.asset_no',
            'site',
            'area',
            'responsible',
            'department',
            'role_id',
            'status_id'
        )
            ->join('asset_details', 'location_details.asset_id', '=', 'asset_details.id')
            ->get();

        // Return the location details as a response with HTTP status code 200 (OK)
        return response(['Location_Details' => $location], 200);
    }

    /**
     * Store a newly created location detail for an asset in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $asset_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $asset_id)
    {
        // Create a new LocationDetails object and store it in the database
        $locationDetails = new LocationDetails();
        $locationDetails->asset_id = $asset_id;
        $locationDetails->site = $request->input('site');
        $locationDetails->area = $request->input('area');
        $locationDetails->responsible = $request->input('responsible');
        $locationDetails->department = $request->input('department');
        $locationDetails->role_id = $request->input('role_id');
        $locationDetails->status_id = $request->input('status_id');
        $locationDetails->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'Location details saved'], 200);
    }

    /**
     * Display the location details for a specific asset.
     *
     * @param  int  $asset_id
     * @return \Illuminate\Http\Response
     */
    public function show($asset_id)
    {
        // Retrieve the location details for the asset with the given $asset_id from the database
        $location = LocationDetails::select(
            'id',
            'asset_id',
            'site',
            'area',
            'responsible',
            'department',
            'role_id',
            'status_id'
        )
            ->where('asset_id', $asset_id)
            ->get();

        // Return the location details as a response with HTTP status code 200 (OK)
        return response(['Location_Details' => $location], 200);
    }

    /**
     * Update the location details for a specific asset in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $assets_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $assets_id)
    {
        // Find the LocationDetails object with the given $assets_id in the database
        $location = LocationDetails::findOrFail($assets_id);

        // Update the attributes of the LocationDetails object with new values from the request
        $location->site = $request->input('site');
        $location->area = $request->input('area');
        $location->responsible = $request->input('responsible');
        $location->department = $request->input('department');
        $location->role_id = $request->input('role_id');
        $location->status_id = $request->input('status_id');

        // Save the updated LocationDetails object to the database
        $location->save();

        // Return a success response with HTTP status code 200 (OK) and a message
        return response(['status' => 200, 'message' => 'Location details are updated'], 200);
    }

    /**
     * Remove the location details for a specific asset from the database.
     *
     * @param  int  $id
     * @return void
     */
    public function delete($id)
    {
        // Find the LocationDetails object with the given $id in the database
        $delete = LocationDetails::find($id);

        // If the LocationDetails object is found, delete it from the database
        if ($delete) {
            $delete->delete();
        }

        // Note: There is no response returned for deletion, so the client will not receive any feedback.
    }
}
