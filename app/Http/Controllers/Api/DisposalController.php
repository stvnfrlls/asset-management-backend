<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisposalRequest;
use App\Models\Asset_details;
use App\Models\Device_specs;
use App\Models\Disposal;
use App\Models\Licensing;
use App\Models\LocationDetails;
use App\Models\Purchases;

class DisposalController extends Controller
{
    /**
     * Retrieve disposed assets.
     *
     * This function retrieves details of disposed assets from the "Disposal" table,
     * ordered by the most recent disposal date.
     *
     * @return \Illuminate\Http\Response The JSON response containing the disposed asset details.
     */
    public function index()
    {
        // Retrieve disposed asset details from the "Disposal" table, ordered by the most recent disposal date.
        $disposed_assets = Disposal::select(
            'asset_id',
            'method',
            'name',
            'date',
            'amount'
        )
            ->orderBy('disposals.updated_at', 'desc')
            ->get();

        // Return a JSON response containing the disposed asset details.
        return response(['disposed_assets' => $disposed_assets], 200);
    }

    /**
     * Store disposal information.
     *
     * This function stores disposal information into the "Disposal" table and performs
     * the deletion of the asset records from "Asset_details", "LocationDetails", and "Purchases" tables.
     * If the asset has device specifications, it also deletes the corresponding records from "Device_specs" and "Licensing" tables.
     *
     * @param \App\Http\Requests\DisposalRequest $request The request containing the disposal information.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(DisposalRequest $request)
    {
        // Retrieve disposal information and assets from the request.
        $information = $request->input('information');
        $assets = $request->input('assets');

        // Loop through each asset and store disposal information and delete asset records accordingly.
        foreach ($assets as $asset) {
            // Create a new instance of the "Disposal" model and save disposal information.
            $disposal = new Disposal();
            $disposal->name = $information['responsible'];
            $disposal->department = $information['department'];
            $disposal->method = $information['method'];
            $disposal->trade_to = $information['tradeTo'];
            $disposal->amount = $information['value'];
            $disposal->date = $information['date'];
            $disposal->asset_id = $asset['asset_id'];
            $disposal->reference = $asset['reference'];
            $disposal->description = $asset['description'];
            $disposal->purpose = $asset['purpose'];
            $disposal->save();

            // Find and delete asset records from "Asset_details", "LocationDetails", and "Purchases" tables.
            $asset_details = Asset_details::find($asset['asset_id']);

            $location_details = LocationDetails::find($asset['asset_id']);
            $location_details->status_id = 6; //Disposed
            $location_details->save();

            $purchase_details = Purchases::find($asset['asset_id']);
            $asset_details->delete();
            $location_details->delete();
            $purchase_details->delete();

            // Find and delete device specifications and licensing records if they exist.
            $device_specs = Device_specs::find($asset['asset_id']);
            if ($device_specs) {
                $licensing = Licensing::find($device_specs->license_id);
            }

            if ($asset_details && $device_specs && $licensing) {
                $asset_details->delete();
                $location_details->delete();
                $purchase_details->delete();
                $device_specs->delete();
                    $licensing->delete();
            } else {
                $asset_details->delete();
                $location_details->delete();
                $purchase_details->delete();
            }
        }

        // Return a JSON response indicating the successful disposal of assets.
        return response(['status' => 200, 'message' => 'Asset Disposed'], 200);
    }

    /**
     * Retrieve disposal details for a specific asset.
     *
     * This function retrieves disposal details for a specific asset from the "Disposal" table.
     *
     * @param int $asset_id The ID of the asset to retrieve disposal details for.
     * @return \Illuminate\Http\Response The JSON response containing the disposal details for the specified asset.
     */
    public function show($asset_id)
    {
        // Retrieve disposal details for the specified asset from the "Disposal" table.
        $disposed_assets = Disposal::select(
            'asset_id',
            'method',
            'name',
            'date',
            'amount'
        )
            ->where('id', $asset_id)
            ->get();

        // Return a JSON response containing the disposal details for the specified asset.
        return response(['Disposal_details' => $disposed_assets], 200);
    }

    /**
     * Delete a disposal record.
     *
     * This function deletes a disposal record from the "Disposal" table.
     *
     * @param int $id The ID of the disposal record to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find and delete the disposal record with the given ID from the "Disposal" table.
        $delete = Disposal::find($id);
        if ($delete) {
            $delete->delete();
        }
    }
}
