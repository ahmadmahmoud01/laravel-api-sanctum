<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProducts() {

        $products = Product::all();

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'products' => $products
        ], 200);

    }

    public function create(Request $request) {

        $validator = validator()->make($request->all(), [

            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'price' => 'required',

        ]);

        if($validator->fails()) {
            return response()->json([0, $validator->errors()->first(), $validator->errors()]);
        }

        $product = Product::create($request->all());

        return response()->json([
            'status' => 1,
            'message' => 'created successfully',
            'product' => $product
        ]);


    }

    public function update(Request $request, Product $product) {

        $product->update($request->all());

        return response()->json([
            'status' => 1,
            'message' => 'updated successfully',
            'product' => $product
        ]);

    }

    public function show(Product $product) {

        return $product;

    }

    public function destroy(Product $product) {

        $product->delete();

        return "deleted successfully";

    }
}
