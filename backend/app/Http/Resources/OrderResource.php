<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'voucher_no' => $this->invoice_no,
            'customer_name' => $this->customer->name,
            'customer_username' => $this->customer->username,
            'msg' => $this->note,
            'total_amount' => $this->details->sum(function ($detail) {
                return $detail->product->price * $detail->qty;
            }),
            'total_qty' => $this->details->sum(function ($item) {
                return $item->qty;
            }),
            'products' => OrderDetailResource::collection($this->details),
            'address' => $this->address,
            'status' => $this->status == 0 ? false : true
        ];
    }
}
