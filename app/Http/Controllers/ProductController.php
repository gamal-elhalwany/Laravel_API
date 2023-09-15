<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResourceCollection;
use App\Http\Resources\ProductResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\ThrowUpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]); // We have  to use this code here to ensure that we'll get the authorization works fine on the that deals with this resource.
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        // return Product::all();
        // return ProductResource::collection(Product::paginate(10)); // this one is used if there is no resource collection file.
        return new ProductResourceCollection (Product::paginate(10));

        // You Can Choose One of The Above Methods, The First one Returns the Data Wrapped into an array of Objects Without a name, But the Second One and 3rd are Returning the Data Wrapped into an array of Objects but with a name.
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
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name'      => $request->name,
            'detail'    => $request->detail,
            'price'     => $request->price,
            'stock'     => $request->stock,
            'discount'  => $request->discount,
        ]);

        return response(['data' => new ProductResource($product)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return response()->json(['error' => 'Product Doesn\'t Belongs to the User!']);
        }
        $product->update($request->all());
        return response(['data' => new ProductResource($product)], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return response()->json(['error' => 'Product Doesn\'t Belongs to the User!']);
        }
        $product->delete();
        return response()->json(['message'=>'Product Removed Successfully!']);
    }
}
