<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetsRequest;
use App\Models\Asset_details;
use App\Models\Device_specs;
use App\Models\Disposal;
use App\Models\Purchases;

use App\Http\Resources\AssetDetailsCollection;
use App\Models\LocationDetails;
use Illuminate\Http\Request;

use Intervention\Image\Facades\Image as InterventionImage;

class AssetDetailsController extends Controller
{
    /**
     * Retrieve a paginated collection of asset details.
     *
     * This function fetches asset details from the database, including related information such as classification,
     * category, asset type, manufacturer, etc. The assets are retrieved in descending order based on their creation date.
     * The results are paginated to improve performance and provide a manageable number of records in each page.
     *
     * @return AssetDetailsCollection The paginated collection of asset details.
     */
    public function index(): AssetDetailsCollection
    {
        // Retrieve asset details from the database with related information using Eloquent ORM.
        $asset_details = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
            'asset_details.img_url',
            'classifications.class_name as classification',
            'categories.category_name as category',
            'asset_types.assetType_name as asset_type',
            'manufacturers.manufacturer_name as manufacturer',
            'asset_details.serial_no',
            'asset_details.model',
            'asset_details.description'
        )
            ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
            ->orderBy('asset_details.created_at', 'desc') // Sort the results by creation date in descending order.
            ->paginate(); // Paginate the results to improve performance.

        // Return the paginated collection wrapped in the AssetDetailsCollection class.
        return new AssetDetailsCollection($asset_details);
    }

    /**
     * Store a new asset with its associated purchase and location details.
     *
     * This function receives a request containing asset information, purchase details, and location details.
     * It creates a new Asset_details record in the database with the provided information.
     * If an image is included in the request, it is processed, saved to the server, and its URL is stored in the database.
     * Additionally, it creates new Purchases and LocationDetails records associated with the newly created asset.
     * The function checks if each save operation was successful before sending a response indicating the status.
     *
     * @param StoreAssetsRequest $request The request containing the asset information, purchase details, and location details.
     * @return \Illuminate\Http\Response The response containing the status and message indicating whether the asset was saved successfully.
     */
    public function store(StoreAssetsRequest $request)
    {
        // Create a new instance of the Asset_details model.
        $Asset_Details = new Asset_details();
        $Asset_Details->asset_no = $request->input('asset_no');

        // Process and store the image if it's included in the request.
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/images/' . $imageName;

            InterventionImage::make($image)->fit(800, 600)->save(public_path($imagePath));
            $Asset_Details->img_url = $imagePath;
        }

        // Fill the Asset_details model with other fields from the request.
        $fields = ['classification', 'category', 'asset_type', 'manufacturer', 'model', 'serial_no', 'description'];
        foreach ($fields as $field) {
            $value = $request->input($field);
            $Asset_Details->$field = ($value === "null") ? null : $value;
        }

        // Save the Asset_details model to the database.
        $Asset_Details->save();

        // Create a new instance of the Purchases model.
        $Purchase_Details = new Purchases();
        $Purchase_Details->asset_id = $Asset_Details->id;

        // Fill the Purchases model with fields from the request.
        $fields = ['item_code', 'company', 'supplier', 'amount', 'date'];
        foreach ($fields as $field) {
            $value = $request->input($field);
            $Purchase_Details->$field = ($value === "null") ? null : $value;
        }

        // Save the Purchases model to the database.
        $Purchase_Details->save();

        // Create a new instance of the LocationDetails model.
        $Location_Details = new LocationDetails();
        $Location_Details->asset_id = $Asset_Details->id;

        // Fill the LocationDetails model with fields from the request.
        $fields = ['site', 'area', 'responsible', 'department', 'role_id', 'status_id', 'remarks'];
        foreach ($fields as $field) {
            $value = $request->input($field);
            $Location_Details->$field = ($value === "null") ? null : $value;
        }

        // Save the LocationDetails model to the database.
        $Location_Details->save();

        // Check if all three save operations were successful before sending the response.
        if ($Asset_Details && $Purchase_Details && $Location_Details) {
            return response([
                'status' => 200,
                'message' => 'Asset Saved'
            ], 200);
        }
    }

    /**
     * Show detailed information about a specific asset.
     *
     * This function retrieves and compiles various details related to a specific asset identified by the given $assets_id.
     * It fetches information from multiple database tables using Eloquent ORM and then returns a JSON response
     * containing asset details, location details, purchase details, specification details, and disposal details (if available).
     *
     * @param int $assets_id The ID of the asset for which details are to be retrieved.
     * @return \Illuminate\Http\Response The JSON response containing all the asset information.
     */
    public function show($assets_id)
    {
        // First query - Retrieve device specifications related to the asset.
        $specDetails1 = Device_specs::select(
            'device_specs.category',
            'os_prior_license_key',
            'processor',
            'components.storage_type',
            'components.storage_size',
            'components.memory_type',
            'components.memory_size',
            'licensings.software',
            'licensings.version',
            'licensings.license_key'
        )
            ->join('licensings', 'device_specs.license_id', '=', 'licensings.id')
            ->join('components', 'device_specs.component_id', '=', 'components.id')
            ->where('asset_id', $assets_id)
            ->first();

        // Second query - Retrieve additional document suite specifications (if available) related to the asset.
        $specDetails2 = Device_specs::select(
            'licensings.software as software_document',
            'licensings.license_key as document_key'
        )
            ->where('asset_id', $assets_id)
            ->join('licensings', 'device_specs.documentsuite_id', '=', 'licensings.id')
            ->first();

        // Combine the specifications from both queries into a single array.
        $specDetails = [];
        if (!empty($specDetails1)) {
            $specDetails = $specDetails1->toArray();
        }
        if (!empty($specDetails2)) {
            $specDetails = array_merge($specDetails, $specDetails2->toArray());
        }

        // Compile all the asset details, location details, purchase details, specification details, and disposal details (if available).
        $data = [
            'asset_details' => Asset_details::select(
                'asset_details.id',
                'asset_details.asset_no',
                'asset_details.img_url',
                'asset_details.classification',
                'asset_details.category',
                'asset_details.asset_type',
                'asset_details.manufacturer',
                'asset_details.serial_no',
                'asset_details.model',
                'asset_details.description'
            )
                ->where('asset_details.id', $assets_id)
                ->first(),

            'location_details' => LocationDetails::select(
                'location_details.asset_id',
                'location_details.site',
                'location_details.area',
                'location_details.responsible',
                'location_details.department',
                'location_details.role_id',
                'location_details.status_id'
            )
                ->where('location_details.asset_id', $assets_id)
                ->first(),

            'purchaseDetails' => Purchases::select(
                'item_code',
                'company',
                'supplier',
                'amount',
                'date'
            )
                ->where('asset_id', $assets_id)
                ->first(),

            'specDetails' => $specDetails,

            'disposalDetails' => Disposal::select(
                'method',
                'name',
                'date',
                'amount'
            )
                ->where('asset_id', $assets_id)
                ->first()
        ];

        // Return the compiled data as a JSON response.
        return response($data);
    }

    /**
     * Update information of a specific asset.
     *
     * This function updates the information of a specific asset identified by the given $assets_id.
     * It receives a request containing the updated asset information, including the asset number, image, classification,
     * category, asset type, manufacturer, serial number, model, and description. The function then updates the asset record
     * in the database with the provided information, including processing and saving the new asset image to the server.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated asset information.
     * @param int $assets_id The ID of the asset to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $assets_id)
    {
        // Find the asset to be updated using the $assets_id.
        $update_asset = Asset_details::findOrFail($assets_id);

        // Update the asset information with the data from the request.
        $update_asset->asset_no = $request->input('asset_no');

        // Check if an image file is included in the request
        if ($request->hasFile('image')) {
            // Process and store the updated image if it's included in the request.
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/images/' . $imageName;

            // Store the image using intervention/image package to handle resizing and optimization if needed.
            InterventionImage::make($image)->fit(800, 600)->save(public_path($imagePath));
            $update_asset->img_url = $imagePath;
        }


        // Update other fields of the asset with the data from the request.
        $update_asset->classification = $request->input('classification');
        $update_asset->category = $request->input('category');
        $update_asset->asset_type = $request->input('asset_type');
        $update_asset->manufacturer = $request->input('manufacturer');
        $update_asset->serial_no = $request->input('serial_no');
        $update_asset->model = $request->input('model');
        $update_asset->description = $request->input('description');

        // Save the updated asset information to the database.
        $update_asset->save();

        // Return a JSON response indicating the successful update.
        return response(['status' => 200, 'message' => 'Asset is updated'], 200);
    }

    /**
     * Delete an asset from the database.
     *
     * This function deletes a specific asset identified by the given $assets_id from the database.
     * It finds the asset using the `$assets_id`, deletes the corresponding record from the "Asset_details" table,
     * and removes all associated information from related tables (if any) due to cascading delete (if defined in the database).
     * After successful deletion, it returns a JSON response indicating the status of the delete operation.
     *
     * @param int $assets_id The ID of the asset to be deleted.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the delete operation.
     */
    public function destroy($assets_id)
    {
        // Find the asset to be deleted using the $assets_id.
        $dispose = Asset_details::find($assets_id);

        // Check if the asset is found and delete it.
        if ($dispose) {
            $dispose->delete();

            // Return a JSON response indicating the successful disposal.
            return response(['status' => 200, 'message' => 'Asset is disposed'], 200);
        }

        // If the asset with the given $assets_id is not found, return a JSON response with an error message.
        return response(['status' => 404, 'message' => 'Asset not found'], 404);
    }
}
