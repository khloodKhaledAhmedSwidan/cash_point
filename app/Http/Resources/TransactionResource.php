<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'user_id'               => $this->user_id != null ?intval($this->user_id): null,
            'user_name'            => $this->user_id != null ?User::where('id',$this->user_id)->first()->name: null,
            'user_phone'            => $this->user_id != null ?User::where('id',$this->user_id)->first()->phone: null,
            'store_id'       => $this->store_id != null ?intval($this->store_id): null,
            'store_name'            => $this->store_id != null ?User::where('id',$this->store_id)->first()->name: null,
            'store_phone'            => $this->store_id != null ?User::where('id',$this->store_id)->first()->phone: null,
            'cash'       =>$this->cash != null ? number_format((float)$this->cash, 2, '.', '') : null,
            'point'       =>$this->point != null ? intval($this->point): null,
            'commission'      => $this->commission != null ?number_format((float)$this->commission, 2, '.', '') :null,
            'order_number' => intval($this->order_number),
            'status' => intval($this->status),
            'rated_or_not' => $this->rates()->count() ,
            'created_at'         => $this->created_at->format('Y-m-d'),
        ];
    }
}
