<?php

namespace App\Http\Resources;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'transaction_id'            => $this->transaction_id  != null ? intval($this->transaction_id) : null,
            'user_id'            => $this->user_id != null ? intval($this->user_id) : null,
            'user_name'                => $this->user_id != null ? User::where('id',$this->user_id)->first()->name : null ,
            'user_phone'                => $this->user_id != null ? User::where('id',$this->user_id)->first()->phone : null ,
            'store_id'            => $this->store_id != null ? intval($this->store_id) : null,
            'store_name'                => $this->store_id != null ? User::where('id',$this->store_id)->first()->name : null ,
            'store_phone'                => $this->store_id != null ? User::where('id',$this->store_id)->first()->phone : null ,
            'rate'            => $this->rate != null ? intval($this->rate) : null,
            'qrcode' => 'https://api.qrserver.com/v1/create-qr-code/?data=' . $this->id,
            'description'            => $this->description != null ? strval($this->description) : null,
            // 'expired_at' => $this->expired_at->format('Y-m-d'),
  
            'created_at'         => $this->created_at->format('Y-m-d'),
        ];
    }
}
