<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;

class CategoryController extends Controller
{
    
    // A doc block comment to describe the following method.

    /**
     * Display a listing of the resource.
     */
    
    // The 'index' method is used to get a list of all 'Product' records.
    public function index()
    {
        // Use Laravel's response helper to return a JSON response containing all 'Product' records.
        // The second parameter, 200, is the HTTP status code for OK.
        return response()->json(Category::all(), 200);
    }

    // Another doc block comment to describe the following method.

    /**
     * Store a newly created resource in storage.
     */
    
    // The 'store' method is used to validate the incoming request and create a new 'Category'.
    public function store(Request $request)
    {
        // Validate the incoming HTTP request with the given rules.
        // 'name' should be present and should not exceed 255 characters.
        // 'description' and 'price' should be present.
        // 'price' should also be a valid numeric value.
        $validatedData = $request->validate([
            'category_name' => 'required|max:255|unique:categories',
        ]);
    
        try {  

        $inputData = $request->all();
        // Create a new 'Category' record in the database with the validated data.
        $category = Category::create($inputData);
        return response()->json([
            'message'=>'Category Created Successfully!!'
        ]);

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating a Category!!'
            ],500);
        }
        // Return the created 'Category' as a JSON response.
        // The second parameter, 201, is the HTTP status code for Created.
       //  return response()->json($category, 201);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the Category from the database using the provided $id
        $category = Category::find($id);

        // Check if the Category was found
        if ($category) {
            // Return the Category as a JSON response with a 200 HTTP status code
            return response()->json($category, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the Category was not found
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'category_name' => 'required|max:255',
        ]);

        $inputData = $request->all();
    
        // Check if the Category was found
        if ($category) {
            try {
                // Update the Category with the validated data
                $category->update($inputData);

                return response()->json([
                    'message'=>'Category Updated Successfully!!'
                ]);
            } 
            catch(\Exception $e){
                \Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while creating a Category!!'
                ],500);
            }
          
            // Return the updated Category as a JSON response with a 200 HTTP status code
           //  return response()->json($category, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the Category was not found
            return response()->json(['message' => 'Category not found'], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if the Category was found
        if ($category) {
            // Delete the Category
            $category->delete();
             // $category
            // Return a 204 No Content HTTP status code
            return response()->json(null, 204);
        } else {
            // Return a 404 Not Found HTTP status code if the Category was not found
            return response()->json(['message' => 'Category not found'], 404);
        }
    }
}
