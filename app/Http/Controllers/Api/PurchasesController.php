<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchases;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{

    public function index()
    {
        // Retrieve all purchases from the database, selecting specific columns.
        $purchases = Purchases::select(
            'asset_id',
            'item_code',
            'company',
            'supplier',
            'amount',
            'date',
        )->get();

        // Return the retrieved purchases as a JSON response with a status code of 200.
        return response(['Purchases' => $purchases], 200);
    }

    public function store(Request $request, $asset_id)
    {
        // Create a new instance of the Purchases model.
        $purchase = new Purchases();

        // Set the attributes of the new Purchase instance from the request data.
        $purchase->asset_id = $asset_id;
        $purchase->item_code = $request->input('item_code');
        $purchase->company = $request->input('company');
        $purchase->supplier = $request->input('supplier');
        $purchase->amount = $request->input('amount');
        $purchase->date = $request->input('date');

        // Save the new Purchase instance to the database.
        $purchase->save();

        // Return a JSON response with a status code of 200 indicating successful creation.
        return response(['status' => 200, 'message' => 'Purchase details Saved'], 200);
    }

    public function show($asset_id)
    {
        // Retrieve purchases with the given asset_id from the database, selecting specific columns.
        $purchases = Purchases::select(
            'asset_id',
            'item_code',
            'company',
            'supplier',
            'amount',
            'date',
        )
            ->where('asset_id', $asset_id)
            ->get();

        // Return the retrieved purchase details as a JSON response with a status code of 200.
        return response(['Purchase_Details' => $purchases], 200);
    }

    public function update(Request $request, $asset_id)
    {
        // Find the Purchase model instance with the given $asset_id, or throw an exception if it doesn't exist.
        $update_purchase = Purchases::findOrFail($asset_id);

        // Update the attributes of the found Purchase instance with the data from the request.
        $update_purchase->item_code = $request->input('item_code');
        $update_purchase->company = $request->input('company');
        $update_purchase->supplier = $request->input('supplier');
        $update_purchase->amount = $request->input('amount');
        $update_purchase->date = $request->input('date');

        // Save the updated Purchase instance to the database.
        $update_purchase->save();

        // Return a JSON response with a status code of 200 indicating the successful update.
        return response(['status' => 200, 'message' => 'Purchase details are updated'], 200);
    }

    public function delete($id)
    {
        // Find the Purchase model instance with the given $id, or return null if it doesn't exist.
        $delete = Purchases::find($id);

        // If a Purchase instance was found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
