<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Asset_details;
use App\Models\AssetType;
use App\Models\Category;
use App\Models\Classifications;
use App\Models\Departments;
use App\Models\LocationDetails;
use App\Models\Manufacturer;
use App\Models\Purchases;
use App\Models\StatusType;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Retrieve the data from the request
        $excelData = $request->input('excelData');

        // Iterate through each row in the $excelData array
        foreach ($excelData as $row) {
            // Store asset details
            $asset_details = new Asset_details();
            $asset_details->asset_no = $row['Asset No.'];
            // Fetch classification ID based on the provided classification name
            $class_id = Classifications::where('class_name', 'like', '%' . $row['Classification'] . '%')->first();
            $asset_details->classification = $class_id->id;
            // Fetch category ID based on the provided category name
            $category_id = Category::where('category_name', 'like', '%' . $row['Category'] . '%')->first();
            $asset_details->category = $category_id->id;
            // Fetch asset type ID based on the provided asset type name
            $assetType_id = AssetType::where('assetType_name', 'like', '%' . $row['Asset Type'] . '%')->first();
            $asset_details->asset_type = $assetType_id->id;
            // Fetch manufacturer ID based on the provided manufacturer name
            $manufacturer_id = Manufacturer::where('manufacturer_name', 'like', '%' . $row['Manufacturer'] . '%')->first();
            $asset_details->manufacturer = $manufacturer_id->id;
            $asset_details->serial_no = $row['Serial No.'];
            $asset_details->model = $row['Model'];
            $asset_details->description = $row['Description'];
            $asset_details->save();

            // Store purchases related to the asset
            $purchases = new Purchases();
            $purchases->asset_id = $asset_details->id;
            $purchases->item_code = $row['Item Code'];
            $purchases->company = $row['Company'];
            $purchases->supplier = $row['Supplier'];
            $purchases->amount = $row['Amount'];
            // Parse the provided date and save it in the correct format
            $carbonDate = Carbon::parse($row['Date']);
            $formattedDate = $carbonDate->format('Y-m-d'); // Example: 2023-07-18
            $purchases->date = $formattedDate;
            $purchases->save();

            // Store location details related to the asset
            $location = new LocationDetails();
            $location->asset_id = $asset_details->id;
            $location->site = $row['Site'];
            $location->area = $row['Area'];
            $location->responsible = $row['Responsible'];
            // Fetch department ID based on the provided department name
            $department_id = Departments::where('dept_name', 'like', '%' . $row['Department'] . '%')->first();
            $location->department = $department_id->id;
            // Fetch user role ID based on the provided role name
            $userRole_id = UserRoles::where('role', 'like', '%' . $row['Roles'] . '%')->first();
            $location->role_id = $userRole_id->id;
            // Fetch status type ID based on the provided status name
            $statusType_id = StatusType::where('status_name', 'like', '%' . $row['Status'] . '%')->first();
            $location->status_id = $statusType_id->id;
            $location->remarks = $row['Remarks'];
            $location->save();
        }

        // Return a success response with HTTP status code 200 (OK)
        return response(['status' => 200], 200);
    }
}
