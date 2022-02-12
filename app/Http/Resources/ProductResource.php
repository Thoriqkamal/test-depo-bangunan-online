<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (!empty($this->created_at)) {
            $created_at = $this->created_at->format('Y-m-d H:i:s');
        } else {
            $created_at = NULL;
        }

        if (!empty($this->updated_at)) {
            $updated_at = $this->updated_at->format('Y-m-d H:i:s');
        }else{
            $updated_at = NULL;
        }
        return [
            'id'                  => $this->id,
            'product_name'        => $this->product_name,
            'product_description' => $this->product_description,
            'product_price'       => $this->product_price,
            'stock_product'       => $this->stock_product,
            'stock_number'        => $this->stock_number,
            'stock_type'          => $this->stock_type,
            'created_at'          => $created_at,
            'updated_at'          => $updated_at
        ];
    }
}
