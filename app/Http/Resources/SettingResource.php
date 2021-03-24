<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'term'               => $this->term != null ?strval($this->term): null,
            'condition'       => $this->condition != null ?strval($this->condition):null,
            'description'       =>$this->description != null ? strval($this->description): null,
            'logo'              => $this->logo != null ?  asset('/uploads/logo/'.$this->logo): null,
            'min_limit_replacement'             =>$this->min_limit_replacement != null ? intval($this->min_limit_replacement): null,
            'client_cash'             =>$this->client_cash != null ? intval($this->client_cash): null,
            'max_commission'             => $this->max_commission != null ?   number_format((float)$this->max_commission, 2, '.', ''): null,
            'scope_of_search'             => $this->scope_of_search != null ?   intval($this->scope_of_search): null,
            'twitter'               => $this->twitter != null ?strval($this->twitter): null,
            'instagram'               => $this->instagram != null ?strval($this->instagram): null,
            'facebook'               => $this->facebook != null ?strval($this->facebook): null,
            'phone'               => $this->phone != null ?strval($this->phone): null,
            'min_text'               => $this->min_text != null ?strval($this->min_text): null,
            'created_at'         => $this->created_at->format('Y-m-d'),
        ];
    }
}
