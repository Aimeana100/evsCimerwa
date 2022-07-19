<?php

namespace App\Http\Resources;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CardTapResource extends JsonResource
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
            'user_id' => $this->user_id,
            'ID_Card' => $this->ID_Card,
            'tapped_at' => $this->tapped_at,
            'card_type' => $this->card_type,
            'status' => $this->status,
            'employee' => EmployeeResource::collection($this->employee),
            'visitor' => VisitorResource::collection($this->visitor),
        ];
    }
}
