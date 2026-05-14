<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with('stock')->latest()->get();

        return view('stocks.index', compact('products'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $stock = Stock::where('product_id', $request->product_id)->first();

        if (!$stock) {

            Stock::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);

        } else {

            $stock->quantity += $request->quantity;

            $stock->save();
        }

        return response()->json([
            'message' => 'Stock Updated Successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $stock = Stock::findOrFail($id);

        // Increase instead of replace
        $stock->quantity = $stock->quantity + $request->quantity;

        $stock->save();

        return response()->json([
            'message' => 'Stock increased successfully'
        ]);
    }
    
}
