<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
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
            'id' => $this->id,
            'names' => $this->names,
            'gender' => $this->gender,
            'ID_Card' => $this->ID_Card,
            'phone' => $this->phone,
            'taps'=> CardTapResource::collection($this->taps),
            'dateJoined' => $this->dateJoined,
            'latestTap' => $this->latestTap,
            'reason' => $this->reason,
            'status' => $this->status,
        ];
    }
}
