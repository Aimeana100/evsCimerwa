<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
// use phpDocumentor\Reflection\Types\This;

class VisitorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map->only(
            'id',
            'names',
            'gender',
            'ID_Card',
            'taps',
            'phone',
            'dateJoined',
            'latestTap',
            'reason',
            'status',
        )->sort();
    }
}
