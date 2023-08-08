<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Retrieve all categories.
     *
     * This function retrieves all categories from the "Category" table and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response The JSON response containing all categories.
     */
    public function index()
    {
        // Retrieve all categories from the "Category" table.
        $categories = Category::select('id', 'category_name')->get();

        // Return a JSON response containing all categories.
        return response(['categories' => $categories], 200);
    }

    /**
     * Store a new category.
     *
     * This function creates a new "Category" record in the database with the provided category name.
     *
     * @param \Illuminate\Http\Request $request The request containing the new category name.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the store operation.
     */
    public function store(Request $request)
    {
        // Create a new instance of the "Category" model.
        $categories = new Category();

        // Set the category name from the request data.
        $categories->category_name = $request->input('Category_Input');

        // Save the new category to the database.
        $categories->save();

        // Return a JSON response indicating the successful addition.
        return response(['status' => 200, 'message' => 'Value is added'], 200);
    }

    /**
     * Update an existing category.
     *
     * This function updates an existing "Category" record in the database with the provided category name.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated category name.
     * @param int $id The ID of the category to be updated.
     * @return \Illuminate\Http\Response The JSON response indicating the status of the update operation.
     */
    public function update(Request $request, $id)
    {
        // Find the category to be updated using the provided $id.
        $update_category = Category::findOrFail($id);

        // Update the category name with the data from the request.
        $update_category->category_name = $request->input('value');

        // Save the updated category to the database.
        $update_category->save();

        // Return a JSON response indicating the successful update.
        return response(['status' => 200, 'message' => 'Value is updated'], 200);
    }

    /**
     * Delete a category.
     *
     * This function deletes an existing "Category" record from the database based on the provided $id.
     *
     * @param int $id The ID of the category to be deleted.
     * @return void
     */
    public function delete($id)
    {
        // Find the category to be deleted using the provided $id.
        $delete = Category::find($id);

        // If the category is found, delete it from the database.
        if ($delete) {
            $delete->delete();
        }
    }
}
