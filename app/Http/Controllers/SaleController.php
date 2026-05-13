<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class SaleController extends Controller
{
    public function index()
    {
    $sales = Sale::with('user')->latest()->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::with('stock')->get();

        return view('sales.create', compact('products'));
    }

   public function store(Request $request)
    {
        $request->validate([

            'product_id' => 'required',

            'quantity' => 'required|integer|min:1'

        ]);

        
        $product = Product::with('stock')
                    ->findOrFail($request->product_id);

        $stock = $product->stock;

        // Check if stock exists
        if (!$stock) {
            return response()->json([
                'status' => false,
                'message' => 'Stock record not found for this product'
            ], 422);
        }
        // Prevent Negative Stock
        if($request->quantity > $product->stock->quantity)
        {
            return response()->json([

                'status' => false,

                'message' => 'Insufficient stock available'

            ], 422);
        }

        $price = $product->price;

        $total = $price * $request->quantity;

        // Create Invoice
        $sale = Sale::create([

            'invoice_no' => 'INV-' . time(),

            'sale_date' => now(),

            'total_amount' => $total,

            'created_by' => auth()->id()

        ]);

        // Create Sale Item
        SaleItem::create([

            'sale_id' => $sale->id,

            'product_id' => $product->id,

            'quantity' => $request->quantity,

            'price' => $price,

            'total' => $total

        ]);

        // Deduct Stock
        $product->stock->quantity -= $request->quantity;

        $product->stock->save();

        return response()->json([

            'status' => true,

            'message' => 'Invoice created successfully'

        ]);
    }
}
