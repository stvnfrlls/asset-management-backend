<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        // Retrieve all manufacturers from the database, selecting only their 'id' and 'manufacturer_name' columns.
        $manufacturers = Manufacturer::select([
            'id',
            'manufacturer_name'
        ])->get();

        // Return the retrieved manufacturers as a JSON response with a status code of 200.
        return response(['manufacturers' => $manufacturers], 200);
    }

    public function store(Request $request)
    {
        // Create a new instance of the Manufacturer model.
        $manufacturer = new Manufacturer();

        // Set the 'manufacturer_name' attribute of the new Manufacturer instance to the value provided in the 'Manufacturer_Input' field of the request.
        $manufacturer->manufacturer_name = $request->input('Manufacturer_Input');

        // Save the new Manufacturer instance to the database.
        $manufacturer->save();

        // Return a JSON response with a status code of 200 indicating successful creation.
        return response(['status' => 200, 'message' => 'value is added'], 200);
    }

    public function update(Request $request, $id)
    {
        // Find the Manufacturer model instance with the given $id, or throw an exception if it doesn't exist.
        $manufacturer = Manufacturer::findOrFail($id);

        // Update the 'manufacturer_name' attribute of the found Manufacturer instance with the value provided in the 'value' field of the request.
        $manufacturer->manufacturer_name = $request->input('value');

        // Save the updated Manufacturer instance to the database.
        $manufacturer->save();

        // Return a JSON response with a status code of 200 indicating the successful update.
        return response(['status' => 200, 'message' => 'value is updated'], 200);
    }

    public function delete($id)
    {
        // Find the Manufacturer model instance with the given $id, or return null if it doesn't exist.
        $manufacturer = Manufacturer::find($id);

        // If a Manufacturer instance was found, delete it from the database.
        if ($manufacturer) {
            $manufacturer->delete();
        }
    }
}
