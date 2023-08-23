<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewsResource;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Throw_;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return new ReviewsResource($product->reviews);
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
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required|exists:users,name|max:255',
            'review' => 'required|min:3|max:255',
            'star' => 'required|integer|between:0,5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $review = new Review($request->all());
        $product->reviews()->save($review);
        return response()->json(['Review' => new ReviewsResource($review)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product, Review $review)
    {
        return $review;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, Review $review)
    {
        $review->update($request->all());
        return response(['data' => new ReviewsResource($review)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product, Review $review)
    {
        $review->delete();
        return response(['Message' => 'Review has been deleted successfully!']);
    }
}
