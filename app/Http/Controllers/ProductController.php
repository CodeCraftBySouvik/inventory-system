<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $products = Product::with('stock')->latest()->paginate(5);
        
          return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_code' => 'required|unique:products',
            'price' => 'required|numeric|min:1'
        ],[
            'price.min' => 'Price must be a positive value'
        ]);

        Product::create($request->all());

        return response()->json([
            'message' => 'Product Added Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'product_code' => 'required|unique:products,product_code,' . $product->id,
            'price' => 'required|numeric'
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Product Updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
         $product->delete();

        return response()->json([
            'message' => 'Product Deleted Successfully'
        ]);
    }
}
