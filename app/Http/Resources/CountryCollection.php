<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
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
                    'code'       => intval($data->code),
                    'currency'       => strval($data->currency),
                    'image'          => $data->image != null ? asset('uploads/countries/'.$data->image): null,
                    'created_at'      => $data->created_at->format('Y-m-d'),
                ];
            });
  
    }
}
