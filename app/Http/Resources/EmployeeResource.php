<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'names'=>$this->names,
            'gender'=>$this->gender,
            'ID_Card'=>$this->ID_Card,
            'phone'=>$this->phone,
            'latestTap'=>$this->latestTap,
            'company'=>$this->company,
            'status'=>$this->status,
            'state'=>$this->state,
        ];
    }
}