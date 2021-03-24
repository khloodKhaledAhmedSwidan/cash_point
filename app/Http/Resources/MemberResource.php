<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                 => intval($this->id),
            'point'               => $this->point != null ?intval($this->point): null,
            'title'       => $this->title != null ?strval($this->title):null,
            'created_at'         => $this->created_at->format('Y-m-d'),
        ];
    }
}
