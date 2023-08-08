<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset_details;
use App\Models\AuditLogs;
use App\Models\Licensing;
use App\Models\LocationDetails;
use App\Models\Purchases;
use App\Models\Transfer_list;

class SearchController extends Controller
{
    public function dashboardData()
    {
        // Count assets that are not disposed of and have certain status IDs
        $countAssets = LocationDetails::whereNotIn('location_details.asset_id', function ($query) {
            $query->select('asset_id')->from('disposals');
        })
            ->whereNotIn('location_details.status_id', [4, 5, 6, 7, 8])
            ->count();

        // Count assets currently in use (with status ID 3)
        $countAssetsInUse = LocationDetails::where('location_details.status_id', '=', 3)->count();

        // Count licenses with status 1
        $countLicenses = Licensing::where('status', '=', '1')->count();

        // Get the latest audit log entries
        $getAuditLog = AuditLogs::orderBy('created_at', 'desc')->take(5)->get();

        // Get the latest transfer list entries
        $getTransferList = Transfer_list::orderBy('created_at', 'desc')->take(5)->get();

        // Count assets per category by joining with categories table
        $countAssetPerCategory = Asset_details::selectRaw('categories.category_name AS category, COUNT(*) as count')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->groupBy('asset_details.category', 'categories.category_name')
            ->get();

        // Count assets per asset type by joining with asset_types table
        $countAssetPerAssetType = Asset_details::selectRaw('asset_types.assetType_name AS type, COUNT(*) as count')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->groupBy('asset_details.asset_type', 'asset_types.assetType_name')
            ->get();

        // Count available software licenses per software category
        $countLicenseAvailablePerCategory = Licensing::selectRaw('software_categories.software_category as software, COUNT(*) as count')
            ->join('software_categories', 'licensings.category', '=', 'software_categories.id')
            ->groupBy('software_categories.software_category', 'licensings.category')
            ->get();

        // Count allocated assets per department with status ID 1
        $countAllocatedAssetsPerDepartment = LocationDetails::selectRaw('departments.dept_name as department, COUNT(*) as count')
            ->where('location_details.status_id', 1)
            ->join('departments', 'location_details.department', '=', 'departments.id')
            ->groupBy('location_details.department', 'departments.dept_name')
            ->get();

        // Return the collected data as a JSON response
        return response([
            'AssetCount' => $countAssets,
            'AssetInUse' => $countAssetsInUse,
            'LicenseCount' => $countLicenses,
            'AuditLogs' => $getAuditLog,
            'TransferList' =>  $getTransferList,
            'AssetPerCategory' => $countAssetPerCategory,
            'AssetPerAssetType' => $countAssetPerAssetType,
            'AvailableSoftwarePerCategory' => $countLicenseAvailablePerCategory,
            'AllocatedAssetsPerDepartment' => $countAllocatedAssetsPerDepartment,
        ]);
    }

    public function getAll()
    {
        // Construct a query to select asset details with relevant information
        $query = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
            'classifications.class_name as classification',
            'categories.category_name as category',
            'asset_types.assetType_name as asset_type',
            'manufacturers.manufacturer_name as manufacturer',
            'asset_details.serial_no',
            'asset_details.model',
        )
            ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
            ->orderBy('asset_details.created_at', 'DESC'); // Retrieve the records ordered by 'created_at' in descending order

        // Get the search results based on the constructed query
        $searchResults = $query->get();

        // Count assets that are not disposed of and have certain status IDs
        $countAssets = LocationDetails::whereNotIn('location_details.asset_id', function ($query) {
            $query->select('asset_id')->from('disposals');
        })
            ->whereNotIn('location_details.status_id', [4, 5, 6, 7, 8])
            ->count();

        // Count assets with status ID 1 (available) and status ID 3 (in use)
        $countAssetsAvailable = LocationDetails::where('status_id', '=', 1)->count();
        $countAssetsInUse = LocationDetails::where('status_id', '=', 3)->count();

        // Return the collected data as a JSON response
        return response([
            'Asset_List' => $searchResults,
            'AssetCount' => $countAssets,
            'AssetsAvailable' => $countAssetsAvailable,
            'AssetsInUse' => $countAssetsInUse
        ]);
    }


    public function getAllDetails()
    {
        // Retrieve asset details with related information
        $assetDetails = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
            'classifications.class_name as classification',
            'categories.category_name as category',
            'asset_types.assetType_name as asset_type',
            'manufacturers.manufacturer_name as manufacturer',
            'asset_details.serial_no',
            'asset_details.model',
            'asset_details.description',
        )
            ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
            ->orderBy('asset_details.created_at', 'DESC')
            ->get()
            ->toArray();

        // Retrieve location details with related information
        $locations = LocationDetails::select(
            'location_details.asset_id',
            'location_details.site',
            'location_details.area',
            'location_details.responsible',
            'departments.dept_name as department',
            'user_roles.role as role',
            'status_types.status_name as status',
            'location_details.remarks'
        )
            ->leftJoin('departments', 'location_details.department', '=', 'departments.id')
            ->leftJoin('user_roles', 'location_details.role_id', '=', 'user_roles.id')
            ->leftJoin('status_types', 'location_details.status_id', '=', 'status_types.id')
            ->orderBy('location_details.created_at', 'DESC')
            ->get()
            ->toArray();

        // Retrieve purchase details for assets
        $purchases = Purchases::select(
            'purchases.asset_id',
            'item_code',
            'company',
            'supplier',
            'amount',
            'date'
        )
            ->orderBy('purchases.created_at', 'DESC')
            ->get()
            ->toArray();

        // Combine asset details, location details, and purchase details using 'asset_id' as the key
        $combinedData = [];

        foreach ($assetDetails as $asset) {
            $id = $asset['id'];
            $combinedData[$id] = $asset;
        }

        foreach ($purchases as $purchase) {
            $id = $purchase['asset_id'];
            if (isset($combinedData[$id])) {
                unset($purchase['asset_id']);
                $combinedData[$id] = array_merge($combinedData[$id], $purchase);
            }
        }
        foreach ($locations as $location) {
            $id = $location['asset_id'];
            if (isset($combinedData[$id])) {
                unset($location['asset_id']);
                $combinedData[$id] = array_merge($combinedData[$id], $location);
            }
        }

        // Create the final array with the desired output format
        $assetList = array_values($combinedData);

        // Count assets that are not disposed of and have certain status IDs
        $countAssets = LocationDetails::whereNotIn('location_details.asset_id', function ($query) {
            $query->select('asset_id')->from('disposals');
        })
            ->whereNotIn('location_details.status_id', [4, 5, 6, 7, 8])
            ->count();

        // Count assets with status ID 1 (available) and status ID 3 (in use)
        $countAssetsAvailable = LocationDetails::where('status_id', '=', 1)->count();
        $countAssetsInUse = LocationDetails::where('status_id', '=', 3)->count();

        // Return the collected data as a JSON response
        return response([
            'Asset_List' => $assetList,
            'AssetCount' => $countAssets,
            'AssetsAvailable' => $countAssetsAvailable,
            'AssetsInUse' => $countAssetsInUse
        ]);
    }


    public function getAllDevice()
    {
        // Construct a query to select device asset details with relevant information
        $query = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
            'classifications.class_name as classification',
            'categories.category_name as category',
            'asset_types.assetType_name as asset_type',
            'manufacturers.manufacturer_name as manufacturer',
            'asset_details.serial_no',
            'asset_details.model',
        )
            ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
            ->where('asset_details.category', '=', 1) // Filter by category ID 1
            ->whereIn('asset_details.asset_type', [1, 2]) // Filter by asset type IDs 1 and 2
            ->orderBy('asset_details.created_at', 'DESC'); // Retrieve the records ordered by 'created_at' in descending order

        // Get the search results based on the constructed query
        $searchResults = $query->get();

        // Count assets that are not disposed of and have certain status IDs
        $countAssets = LocationDetails::whereNotIn('location_details.asset_id', function ($query) {
            $query->select('asset_id')->from('disposals');
        })
            ->whereNotIn('location_details.status_id', [4, 5, 6, 7, 8])
            ->count();

        // Count assets with status ID 1 (available) and status ID 3 (in use)
        $countAssetsAvailable = LocationDetails::where('status_id', '=', 1)->count();
        $countAssetsInUse = LocationDetails::where('status_id', '=', 3)->count();

        // Return the collected data as a JSON response
        return response([
            'Asset_List' => $searchResults,
            'AssetCount' => $countAssets,
            'AssetsAvailable' => $countAssetsAvailable,
            'AssetsInUse' => $countAssetsInUse
        ]);
    }

    public function getAssetList()
    {
        // Retrieve a list of asset IDs and asset numbers that are not disposed of
        $asset_list = Asset_details::select(
            'id',
            'asset_no'
        )
            ->whereNotIn('asset_details.id', function ($query) {
                $query->select('asset_id')->from('disposals');
            })
            ->get();

        // Return the asset list as a JSON response
        return response(['Asset_List' =>  $asset_list], 200);
    }

    public function getDeviceAssetNo()
    {
        // Retrieve a list of asset IDs and asset numbers for devices (category 1, asset types 1 and 2) that are not in transfer lists
        $asset_list = Asset_details::select('id', 'asset_no')
            ->whereNotIn('asset_details.id', function ($query) {
                $query->select('asset_id')->from('transfer_lists');
            })
            ->where('asset_details.category', '=', 1)
            ->whereIn('asset_details.asset_type', [1, 2]) // Filter by asset type IDs 1 and 2
            ->get();

        // Return the asset list as a JSON response
        return response(['Asset_List' => $asset_list], 200);
    }

    public function getAssetNo()
    {
        // Retrieve a list of all asset IDs and asset numbers that are not in transfer lists
        $asset_list = Asset_details::select('id', 'asset_no')
            ->whereNotIn('asset_details.id', function ($query) {
                $query->select('asset_id')->from('transfer_lists');
            })
            ->get();

        // Return the asset list as a JSON response
        return response(['Asset_List' => $asset_list], 200);
    }

    public function availableOffice()
    {
        // Retrieve a list of available office software licenses with relevant information
        $available_Office = Licensing::select(
            'licensings.id',
            'software_categories.software_category as category',
            'software',
            'version',
            'license_key',
            'license_statuses.status as status'
        )
            ->where('licensings.category', '=', '2') // Filter by software category ID 2 (office software)
            ->where('license_statuses.id', '=', '1') // Filter by license status ID 1 (available)
            ->join('software_categories', 'licensings.category', '=', 'software_categories.id')
            ->join('license_statuses', 'license_statuses.id', '=', 'licensings.status')
            ->get();

        // Return the list of available office software licenses as a JSON response
        return response(['available_Office' => $available_Office], 200);
    }

    public function getAssetsWithDeviceSpecs()
    {
        // Retrieve a list of asset IDs and asset numbers for assets with device specifications
        $AssetsWithDeviceSpecs = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
        )
            ->where('asset_details.category', '=', 1) // Filter by category ID 1
            ->whereIn('asset_details.asset_type', [1, 2]) // Filter by asset type IDs 1 and 2
            ->whereIn('asset_details.id', function ($query) {
                $query->select('asset_id')->from('device_specs');
            }) // Filter by asset IDs present in the 'device_specs' table
            ->get();

        // Return the list of assets with device specifications as a JSON response
        return response(['AssetsWithDeviceSpecs' => $AssetsWithDeviceSpecs], 200);
    }

    public function getDisposedAssets()
    {
        // Retrieve asset details of disposed assets with related information
        $assetDetails = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
            'classifications.class_name as classification',
            'categories.category_name as category',
            'asset_types.assetType_name as asset_type',
            'manufacturers.manufacturer_name as manufacturer',
            'asset_details.serial_no',
            'asset_details.model',
            'asset_details.description',
            'asset_details.deleted_at',
        )
            ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
            ->orderBy('asset_details.created_at', 'DESC')
            ->withTrashed()
            ->whereNotNull('asset_details.deleted_at')
            ->get()
            ->toArray();

        // Retrieve location details of disposed assets with related information
        $locations = LocationDetails::select(
            'location_details.asset_id',
            'location_details.site',
            'location_details.area',
            'location_details.responsible',
            'departments.dept_name as department',
            'user_roles.role as role',
            'status_types.status_name as status',
            'location_details.remarks',
            'location_details.deleted_at',
        )
            ->leftJoin('departments', 'location_details.department', '=', 'departments.id')
            ->leftJoin('user_roles', 'location_details.role_id', '=', 'user_roles.id')
            ->leftJoin('status_types', 'location_details.status_id', '=', 'status_types.id')
            ->withTrashed()
            ->whereNotNull('location_details.deleted_at')
            ->get()
            ->toArray();

        // Retrieve purchase details of disposed assets
        $purchases = Purchases::select(
            'purchases.asset_id',
            'item_code',
            'company',
            'supplier',
            'amount',
            'date',
            'purchases.deleted_at',
        )
            ->withTrashed()
            ->whereNotNull('purchases.deleted_at')
            ->get()
            ->toArray();

        // Combine asset details, location details, and purchase details using 'asset_id' as the key
        $combinedData = [];

        foreach ($assetDetails as $asset) {
            $id = $asset['id'];
            $combinedData[$id] = $asset;
        }

        foreach ($purchases as $purchase) {
            $id = $purchase['asset_id'];
            if (isset($combinedData[$id])) {
                unset($purchase['asset_id']);
                $combinedData[$id] = array_merge($combinedData[$id], $purchase);
            }
        }
        foreach ($locations as $location) {
            $id = $location['asset_id'];
            if (isset($combinedData[$id])) {
                unset($location['asset_id']);
                $combinedData[$id] = array_merge($combinedData[$id], $location);
            }
        }

        // Create the final array with the desired output format
        $disposedDetails = array_values($combinedData);

        // Return the collected disposed asset details as a JSON response
        return response([
            'disposedDetails' => $disposedDetails,
        ]);
    }
}
