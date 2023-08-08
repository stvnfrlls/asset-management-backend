<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceSpecsRequest;
use App\Models\Asset_details;
use App\Models\Components;
use App\Models\Device_specs;
use App\Models\Licensing;
use Illuminate\Http\Request;

class DeviceSpecsController extends Controller
{
    /**
     * Retrieve available device details.
     *
     * This function retrieves device details of available devices from the "Asset_details", "Device_specs",
     * "classifications", "categories", "asset_types", and "manufacturers" tables, excluding those present in the "transfer_lists" table.
     *
     * @return \Illuminate\Http\Response The JSON response containing the available device details.
     */
    public function index()
    {
        // Retrieve available device details from the relevant tables and exclude those present in the "transfer_lists" table.
        $Device_details = [
            'Available_Devices' => [
                'Details' => Asset_details::select(
                    'asset_details.id',
                    'asset_details.asset_no',
                    'classifications.class_name as classification',
                    'categories.category_name as category',
                    'asset_types.assetType_name as asset_type',
                    'manufacturers.manufacturer_name as manufacturer',
                    'asset_details.serial_no',
                    'asset_details.model',
                )
                    ->whereNotIn('asset_details.id', function ($query) {
                        $query->select('asset_id')->from('transfer_lists');
                    })
                    ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
                    ->join('categories', 'asset_details.category', '=', 'categories.id')
                    ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
                    ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
                    ->get(),
                'Specification' => Device_specs::select(
                    'asset_id',
                    'licensings.operating_sys as os',
                    'licensings.version as version',
                    'licensings.license_key as license_key',
                    'components.storage_type as storage_type',
                    'components.storage_size as storage_size',
                    'components.memory_type as memory_type',
                    'components.memory_size as memory_size',
                    'processor',
                    'os_prior_license_key'
                )
                    ->whereNotIn('asset_id', function ($query) {
                        $query->select('asset_id')->from('transfer_lists');
                    })
                    ->join('licensings', 'device_specs.license_id', '=', 'licensings.id')
                    ->join('components', 'device_specs.component_id', '=', 'components.id')
                    ->get(),
            ]
        ];

        // Return a JSON response containing the available device details.
        return response([$Device_details], 200);
    }

    /**
     * Store device specifications.
     *
     * This function stores device specifications into the "Device_specs", "Components", and "Licensing" tables.
     *
     * @param \App\Http\Requests\DeviceSpecsRequest $request The request containing the device specifications.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(DeviceSpecsRequest $request)
    {
        // Create a new instance of the "Components" model and save the component information.
        $component = new Components();
        $component->storage_type = $request->input('storageType');
        $component->storage_size = $request->input('storageSize');
        $component->memory_type = $request->input('memoryType');
        $component->memory_size = $request->input('memorySize');
        $component->save();

        // Create a new instance of the "Device_specs" model and save the device specifications.
        $device_specs = new Device_specs();
        $device_specs->asset_id = $request->input('assetID');
        $device_specs->license_id = $request->input('licenseID');

        // Update the license status to 2 (In Use).
        $updateLicenseStatus = Licensing::find($request['licenseID']);
        $updateLicenseStatus->status = 2;
        $updateLicenseStatus->save();

        // Save the document suite information if provided.
        if ($request->input('documentSuite') != null) {
            $device_specs->documentsuite_id = $request->input('documentSuite');
            $updateDocumentSuite = Licensing::find($request['documentSuite']);
            $updateDocumentSuite->status = 2;
            $updateDocumentSuite->save();
        }

        // Save the component ID and other device specifications.
        $device_specs->component_id = $component->id;
        $device_specs->processor = $request->input('processor');
        $device_specs->category = $request->input('category');
        $device_specs->os_prior_license_key = $request->input('priorKey');
        $device_specs->save();

        // Return a JSON response indicating the successful addition of device specifications.
        return response(['status' => 200, 'message' => 'Device specification saved'], 200);
    }

    /**
     * Retrieve device details for a specific asset.
     *
     * This function retrieves device details of a specific asset from the "Device_specs", "licensings", and "components" tables.
     *
     * @param int $asset_id The ID of the asset to retrieve device details for.
     * @return \Illuminate\Http\Response The JSON response containing the device details for the specified asset.
     */
    public function show($asset_id)
    {
        // Retrieve device details for the specified asset from the relevant tables.
        $device_data = Device_specs::select(
            'asset_id',
            'licensings.software as os',
            'licensings.version as version',
            'licensings.license_key as license_key',
            'components.storage_type as storage_type',
            'components.storage_size as storage_size',
            'components.memory_type as memory_type',
            'components.memory_size as memory_size',
            'processor',
            'os_prior_license_key'
        )
            ->where('asset_id', $asset_id)
            ->join('licensings', 'device_specs.license_id', '=', 'licensings.id')
            ->join('components', 'device_specs.component_id', '=', 'components.id')
            ->get();

        $documentSuite_data = Device_specs::select(
            'licensings.software as software_document',
            'licensings.license_key as document_key',
        )
            ->where('asset_id', $asset_id)
            ->join('licensings', 'device_specs.documentsuite_id', '=', 'licensings.id')
            ->get();

        // Append the data from $documentSuite_data to $device_data
        $merged_data = $device_data->concat($documentSuite_data)->toArray();

        // Return the merged data as a JSON response
        return response(['Device_Details' => $merged_data], 200);
    }

    /**
     * Update device details for a specific asset.
     *
     * This function updates device details for a specific asset in the "Device_specs", "Components", and "Licensing" tables.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated device details.
     * @param int $assets_id The ID of the asset to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $assets_id)
    {
        // Find or create Device_specs for the specified asset.
        $device_specs = Device_specs::firstOrNew(['asset_id' => $assets_id]);
        $device_specs->processor = $request->input('processor');
        $device_specs->os_prior_license_key = $request->input('prior_key');
        $device_specs->save();

        // Find or create Components for the device.
        $component = Components::firstOrNew(['id' => $device_specs->component_id]);
        $component->storage_type = $request->input('storage_type');
        $component->storage_size = $request->input('storage_size');
        $component->memory_type = $request->input('memory_type');
        $component->memory_size = $request->input('memory_size');
        $component->save();

        $componentId = $component->id;
        $device_specs->component_id = $componentId;
        $device_specs->save();
        if (!$component->exists) {
            // Handle the case when a new component is created.
        }

        // Find or create Licensing for Operating System.
        $licensing = Licensing::firstOrNew(['id' => $device_specs->license_id]);
        $licensing->software = $request->input('software');
        $licensing->version = $request->input('version');
        $licensing->license_key = $request->input('license_key');
        $licensing->save();

        $licensingId = $licensing->id;
        $device_specs->license_id = $licensingId;
        $device_specs->save();
        if (!$licensing->exists) {
            // Handle the case when a new licensing record is created.
        }

        // Find or create Licensing for Document Suite.
        $docSuite = Licensing::firstOrNew(['id' => $device_specs->documentsuite_id]);
        $docSuite->category = 2;
        $docSuite->software = $request->input('docSuite');
        $docSuite->license_key = $request->input('docSuite_key');
        $docSuite->status = 2;
        $docSuite->save();

        $docSuiteId = $docSuite->id;
        $device_specs->documentsuite_id = $docSuiteId;
        $device_specs->save();
        if (!$docSuite->exists) {
            // Handle the case when a new licensing record for the document suite is created.
        }

        // Return a JSON response indicating the successful update of device details.
        return response(['status' => 200, 'message' => 'Device details are updated'], 200);
    }
}
