<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'ID'     =>  $this->id,
            'Title'     =>  $this->name,
            'Description'    =>  $this->detail,
            'Price'     =>  $this->price,
            'Discount'  =>  $this->discount,
            'TotalPrice' => round((1-($this->discount/100)) * $this->price,2),
            'Stock'     =>  $this->stock == 0 ? 'Out of Stock' : $this->stock,
            'user_id'  => $this->user_id,
            'Rating'     => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count()) : 'No Ratings Yet!',
            'href'      => [
                'reviews' => route('reviews.index',$this->id)
            ],
        ];
        // Here we can change the shape of the returning data from request, in the first line we leave it as default.
    }
}
