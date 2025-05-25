<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_name' => $this->product->name,
            'product_logo' => url('download/'.$this->product->logo),
            'qty' => $this->qty,
            'price' => $this->product->price,
        ];
    }
}
