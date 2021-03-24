<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BankCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
        $this->collection->transform(function($data){ 
            return [
                'id'              => intval($data->id),
                'name'            => strval($data->name),
                'created_at'      => $data->created_at->format('Y-m-d'),
            ];
        });
    }
}
