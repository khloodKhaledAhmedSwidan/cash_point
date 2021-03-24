<?php

namespace App\Http\Resources;

use App\Models\Bank;
use App\Models\Country;
use App\Models\Member;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'phone'               => $this->phone != null ?strval($this->phone): null,
            'name'       => $this->name != null ?strval($this->name):null,
            // 'bank_id'       =>$this->bank_id != null ? intval($this->bank_id): null,
            // 'bank'       =>$this->bank_id != null ? new BankCollection(Bank::where('id',$this->bank_id)->get()): null,
            'type'      => intval($this->type),
            'active' => intval($this->active),
            'api_token' => strval($this->api_token),
            'membership_num' => $this->membership_num != null ?intval($this->membership_num): null ,
            'image'              => $this->image != null ?  asset('/uploads/users/'.$this->image): null,
            'last_login_at' => $this->last_login_at != null ? $this->last_login_at:null ,
            // 'bank_account' => $this->bank_account != null ? strval($this->bank_account):null ,
            'country_id' => $this->country_id  != null ? intval($this->country_id): null,
            'country' => $this->country_id  != null ?new CountryCollection(Country::where('id',$this->country_id)->get()): null,
            'qrcode' => 'https://api.qrserver.com/v1/create-qr-code/?data=' . url('qr-client-data/' . $this->phone),
            'ratesClient' =>  $this->rates()->count() > 0 ? RateResource::collection($this->rates()->get()): null,
            'member_id'       =>$this->member_id  != null ? intval($this->member_id): null,
            'member'       =>$this->member_id  != null ? new MemberResource(Member::where('id',$this->member_id)->first()): null,

            'created_at'         => $this->created_at->format('Y-m-d'),
        ];
    }
}
