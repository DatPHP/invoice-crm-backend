<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Begin the declaration of the ProductController class, which extends the base Controller class.
class ProductController extends Controller
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

       
        $product_list = Product::with('category')->get();

        return response()->json($product_list, 200);
    }

    // Another doc block comment to describe the following method.

    /**
     * Store a newly created resource in storage.
     */
    
    // The 'store' method is used to validate the incoming request and create a new 'Product'.
    public function store(Request $request)
    {

        // dd('Hi Henry');
        // exit;

        // Validate the incoming HTTP request with the given rules.
        // 'name' should be present and should not exceed 255 characters.
        // 'description' and 'price' should be present.
        // 'price' should also be a valid numeric value.
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);
    
        try {  

        $inputData = $request->all();

        if ($image = $request->file('image')) {
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $image,$imageName);
            $inputData['image'] = "$imageName";
        }

        // Create a new 'Product' record in the database with the validated data.
        $product = Product::create($inputData);
        return response()->json([
            'message'=>'Product Created Successfully!!'
        ]);

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating a product!!'
            ],500);
        }
        // Return the created 'Product' as a JSON response.
        // The second parameter, 201, is the HTTP status code for Created.
       //  return response()->json($product, 201);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the product from the database using the provided $id
        $product = Product::find($id);

        // Check if the product was found
        if ($product) {
            // Return the product as a JSON response with a 200 HTTP status code
            return response()->json($product, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $inputData = $request->all();

        if ($image = $request->file('image')) {
            // remove old image
            if($product->image){
                $exists = Storage::disk('public')->exists("product/image/{$product->image}");
                if($exists){
                    Storage::disk('public')->delete("product/image/{$product->image}");
                }
            }
            
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $image,$imageName);

            $inputData['image'] = "$imageName";
        }else{
            unset($inputData['image']);
        }
    
        // Check if the product was found
        if ($product) {
            try {
                // Update the product with the validated data
                $product->update($inputData);

                return response()->json([
                    'message'=>'Product Updated Successfully!!'
                ]);
            }
            catch(\Exception $e){
                \Log::error($e->getMessage());
                return response()->json([
                    'message'=>'Something goes wrong while creating a product!!'
                ],500);
            }
          
            // Return the updated product as a JSON response with a 200 HTTP status code
           //  return response()->json($product, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if the product was found
        if ($product) {
            // Delete the product
            $product->delete();

            // Return a 204 No Content HTTP status code
            return response()->json(null, 204);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}  