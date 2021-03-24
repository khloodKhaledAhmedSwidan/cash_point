<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return
        $this->collection->transform(function($data){ 
            return [
                'id'              => intval($data->id),
                'user_id'         => intval($data->user_id),
                'admin_id'         => intval($data->admin_id),
                'link'            => strval($data->link),
                'image'           => $data->image != null ? asset('uploads/sliders/'.$data->image): null,
                'created_at'      => $data->created_at->format('Y-m-d'),
            ];
        });
    }
}
