<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset_details;


class InventoryController extends Controller
{
    /**
     * Get inventory data for assets and asset types.
     *
     * This function retrieves asset details and the count of assets for each asset type from the database.
     *
     * @return \Illuminate\Http\Response The JSON response containing the inventory data.
     */
    public function getinventoryData()
    {
        // Retrieve asset details for assets that are not in the transfer_lists table.
        $resultAssetDetails = Asset_details::select(
            'asset_details.id',
            'asset_details.asset_no',
            'classifications.class_name as classification',
            'categories.category_name as category',
            'asset_types.assetType_name as asset_type',
            'manufacturers.manufacturer_name as manufacturer',
            'asset_details.serial_no',
            'asset_details.model',
            'asset_details.description'
        )
            ->whereNotIn('asset_details.id', function ($query) {
                $query->select('asset_id')->from('transfer_lists');
            })
            ->join('classifications', 'asset_details.classification', '=', 'classifications.id')
            ->join('categories', 'asset_details.category', '=', 'categories.id')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->join('manufacturers', 'asset_details.manufacturer', '=', 'manufacturers.id')
            ->get();

        // Retrieve the count of assets for each asset type.
        $resultCountAssetType = Asset_details::selectRaw('asset_types.assetType_name as Asset_Type, COUNT(*) as count')
            ->join('asset_types', 'asset_details.asset_type', '=', 'asset_types.id')
            ->whereNotIn('asset_details.id', function ($query) {
                $query->select('id')->from('transfer_lists');
            })
            ->groupBy('asset_details.asset_type', 'asset_types.assetType_name')
            ->get();

        // Return a JSON response containing the inventory data.
        return response([
            'status' => 200,
            'Asset_Details' => $resultAssetDetails,
            'Count_AssetType' => $resultCountAssetType
        ], 200);
    }
}
