<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionResource extends JsonResource
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
            'total'       => $this->total != null ?number_format((float)$this->total, 2, '.', ''): null,
            // 'paid'       => $this->paid != null ?number_format((float)$this->paid, 2, '.', ''): null,
            // 'remain'       => $this->remain != null ?number_format((float)$this->remain, 2, '.', ''): null,
            'image'            => $this->image != null ?asset('uploads/commissions/'.$this->image): null,
            'invoice'            => $this->invoice != null ?intval($this->invoice): null,
            'status'       =>$this->status != null ? intval($this->status) : null,
            'coupon'       =>$this->coupon != null ? number_format((float)$this->coupon, 2, '.', '') : null,
            'coupon_id'       =>$this->coupon_id != null ? intval($this->coupon_id) : null,

            'created_at'         => $this->created_at->format('Y-m-d'),
        ];
    }
}
