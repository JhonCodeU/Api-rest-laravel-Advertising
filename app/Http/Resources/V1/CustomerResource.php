<?php

namespace App\Http\Resources\V1;

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
        return [
            'document' => $this->dni,
            'name' => $this->name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->cell_phone,
            'habeasData' => $this->habeas_data ? true : false,
            'city' => $this->city->name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
