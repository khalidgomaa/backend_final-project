<?php

namespace App\Http\Resources;

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
        // return parent::toArray($request);
        return
        [
        // 'id' =>$this->id , 
        'user_id' =>$this->user_id , 
        'user' =>$this->user, 
        'total_price' =>$this->total_price, 
        // 'orders__items' =>$this->orders_Items,
        // "pets" => OrderItemResource::collection($this->orders_Items )

        ] ;
    }
}
