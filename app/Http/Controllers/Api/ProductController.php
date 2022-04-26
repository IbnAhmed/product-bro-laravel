<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

use App\Http\Resources\ProductResourceCollection;
use App\Http\Resources\ProductResource;
use Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // item per page
        if($request->has('per_page')){
            $per_page = $request->per_page;
            
            if($per_page == 'all'){
                $per_page = Product::count();
            }
        } else {
            $per_page = 10;
        }

        $products = Product::paginate($per_page);

        foreach($products as $product){
            $product->image_url = asset_cloud($product->image_url);
        }

        return (new ProductResourceCollection($products))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'required|image',
        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->created_by = Auth::id();

        $path = $request->file('image')->store('public/products');
        $product->image_url = Storage::url($path);

        $product->save();

        Log::info("Product ID {$product->id} created successfully.");

        $product->image_url = asset_cloud($product->image_url);

        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->image_url = asset_cloud($product->image_url);
        return (new ProductResource($product))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable',
            'price' => 'numeric',
            'image' => 'image',
        ]);

        if($request->has('title')){
            $product->title = $request->title;
        }
        if($request->has('description')){
            $product->description = $request->description;
        }
        if($request->has('price')){
            $product->price = $request->price;
        }

        $product->updated_by = Auth::id();

        if($request->hasFile('image')){
            $filename = str_replace('/storage/', '', $product->image_url);
            // remove old image
            unlink(storage_path('app/public/'.$filename));

            $path = $request->file('image')->store('public/products');
            $product->image_url = Storage::url($path);
        }

        $product->save();

        Log::info("Product ID {$product->id} updated successfully.");

        $product->image_url = asset_cloud($product->image_url);

        return (new ProductResource($product))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $filename = str_replace('/storage/', '', $product->image_url);
        // remove old image
        unlink(storage_path('app/public/'.$filename));

        $product->delete();

        Log::info("Product ID {$product->id} deleted successfully.");

        return response(null, 204);
    }
}
