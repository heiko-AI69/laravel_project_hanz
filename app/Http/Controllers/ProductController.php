<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Products::with('category')->where('is_deleted', false)->get();
  

        return view('products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::where('is_deleted', false)->get();
        return view('product_form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_image' => 'nullable',
            'product_name' => 'required|unique:products,product_name',
            'category' => 'required|exists:categories,category_id',
            'price' => 'required|decimal:0,2',
            'stocks' => 'required|integer|min:0'
        ]);
        $validated['category_id'] = $request->category;
        if($request->hasFile('product_image')){
            $filenameWithExtensions = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtensions, PATHINFO_FILENAME);
            $extensions = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '-' . time() . '-' . $extensions;
            $request->file('product_image')->storeAs('Uploads/Product Images', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }
        $product = Products::create($validated);
        if(!$product){
            return redirect()->route('products')->with([
                'message' => 'cant add product',
                'type' => 'error'
            ]);
        }
        return redirect()->route('products')->with([
            'message' => 'successfull add product',
            'type' => 'success'
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
    public function edit(string $product_id)
    {
        $product = Products::findorfail($product_id);
        $categories = Categories::where('is_deleted', false)->get();

        return view('product_form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
        $product = Products::findorfail($product_id);

        $validated = $request->validate([
            'product_image' => 'nullable',
            'product_name' => 'required|unique:products,product_name,' . $product_id . ',product_id',
            'category' => 'required|exists:categories,category_id',
            'price' => 'required|decimal:0,2',
            'stocks' => 'required|integer|min:0'
        ]);
        $validated['category_id'] = $request->category;
        if($request->hasFile('product_image')){
            $filenameWithExtensions = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtensions, PATHINFO_FILENAME);
            $extensions = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '-' . time() . '-' . $extensions;
            $request->file('product_image')->storeAs('Uploads/Product Images', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }
        if($product->update($validated)){
            return redirect()->route('products')->with([
                'message' => 'successfully updated the product',
                'type' => 'success'
            ]);
        }
        return redirect()->route('products')->with([
            'message' => 'unsuccessfull updated the product',
            'type' => 'error'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $product = Products::findorfail($product_id);
        $product->is_deleted = true;
        $product->save();
        return redirect()->route('products')->with([
            'message' => 'Product deleted',
            'type' => 'success'
        ]);
    }
}
