<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferListRequest;
use App\Models\LocationDetails;
use App\Models\Transfer_list;
use Illuminate\Http\Request;

class TransferListController extends Controller
{
    public function index()
    {
        // Retrieve a history of asset transfers with related information
        $history = Transfer_list::select(
            'asset_details.asset_no',
            'from',
            'site',
            'area',
            'responsible',
            'user_roles.role as role',
            'transferred_date',
            'status_types.status_name as status'
        )
            ->join('asset_details', 'asset_details.id', '=', 'transfer_lists.asset_id')
            ->join('user_roles', 'user_roles.id', '=', 'transfer_lists.role_id')
            ->join('status_types', 'status_types.id', '=', 'transfer_lists.status_id')
            ->orderBy('transfer_lists.created_at', 'DESC') // Retrieve the records ordered by 'created_at' in descending order
            ->get();

        // Return the asset transfer history as a JSON response
        return response(['history' => $history], 200);
    }

    public function store(TransferListRequest $request)
    {
        // Update the location details of the asset being transferred
        $updateLocationDetails = LocationDetails::find($request['asset_id']);
        $updateLocationDetails->site = $request['site'];
        $updateLocationDetails->area = $request['area'];
        $updateLocationDetails->responsible = $request['responsible'];
        $updateLocationDetails->role_id = $request['role_id'];
        $updateLocationDetails->status_id = $request['status_id'];
        $updateLocationDetails->department = $request['department_id'];
        $updateLocationDetails->save();

        // Create a new asset transfer record
        Transfer_list::create($request->only(
            [
                'asset_id',
                'from',
                'site',
                'area',
                'responsible',
                'role_id',
                'department',
                'transferred_date',
                'status_id'
            ]
        ));

        // Return a JSON response indicating successful transfer
        return response(['status' => 200, 'message' => 'Transfer Saved']);
    }
}
