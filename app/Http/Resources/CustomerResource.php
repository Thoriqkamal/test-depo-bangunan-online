<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id'               => $this->id,
            'customer_name'    => $this->customer_name,
            'customer_email'   => $this->customer_email,
            'customer_mobile'  => $this->customer_mobile,
            'customer_address' => $this->customer_address,
            'created_at'       => $created_at,
            'updated_at'       => $updated_at
        ];
    }
}
