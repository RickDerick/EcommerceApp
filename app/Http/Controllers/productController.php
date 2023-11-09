<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validataData= $request->validate([
            'name'=>'required|max:255',
            'description'=>'required',
            'price'=>'required|numeric',
        ]);
        $product= Product::create($validataData);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product= Product::find($id);
       
        if ($product){
            return response()->json($product,200); //ok
            
        }else{
            return response()->json(['message'=>'Product not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validataData= $request->validate([
            'name'=>'required|max:255',
            'description'=>'required',
            'price'=>'required|numeric',
        ]);

        if($product){
            $product->update( $validataData);
            return response()->json($product,200);
        }else {
            return response()->json(['message'=>'Product not found']);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product){
            $product->delete();
            return response()->json(null,204);

        }else {
            return response()->json(['message'=>'product not found'], 404);
        }
    }
}
