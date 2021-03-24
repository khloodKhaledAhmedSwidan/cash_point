<?php

namespace App\Http\Resources;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);

      return [
        'id'                 => intval($this->id),
        'phone'               => $this->phone != null ?strval($this->phone): null,
        'name'       => $this->name != null ?strval($this->name):null,
        'bank_id'       =>$this->bank_id != null ? intval($this->bank_id): null,
        'bank'       =>$this->bank_id != null ? new BankCollection(Bank::where('id',$this->bank_id)->get()): null,
        'type'      => intval($this->type),
        'category_id'       =>$this->category_id != null ? intval($this->category_id): null,    
        'category'       =>$this->category_id != null ? new CategoryCollection(Category::where('id',$this->category_id)->get()): null,
        'active' => intval($this->active),
        'api_token' => strval($this->api_token),
        'description' =>$this->description != null ? strval($this->description): null,
        'latitude'   =>  $this->latitude != null ? $this->latitude: null ,
        'longitude'   =>  $this->longitude != null ? $this->longitude: null ,
        'membership_num' => $this->membership_num != null ?intval($this->membership_num): null ,
        'commission' => $this->commission != null ? intval($this->commission): null ,
        'logo'              => $this->logo != null ?  asset('/uploads/users/'.$this->logo): null,
        'image'              => $this->image != null ?  asset('/uploads/users/'.$this->image): null,
        'file'  => $this->file != null ?asset('/uploads/users/files/'.$this->file):null,
        'arranging' =>$this->arranging != null ?intval($this->arranging) :null,
        'last_login_at' => $this->last_login_at != null ? $this->last_login_at:null ,
        'trade_register' => $this->trade_register != null ? asset('/uploads/users/trades/'.$this->trade_register):null ,
        'bank_account' => $this->bank_account != null ? strval($this->bank_account):null ,
        'point_equal_SR' => $this->point_equal_SR != null ?intval($this->point_equal_SR):null ,
        'country_id' => $this->country_id  != null ? intval($this->country_id): null,
        'country' => $this->country_id  != null ?new CountryCollection(Country::where('id',$this->country_id)->get()): null,
        // 'barcode' => 'https://api.qrserver.com/v1/create-qr-code/?data=' . url('qr-client-data/' . $this->phone),
        'sliders' =>  $this->sliders()->count() > 0 ? new SliderCollection($this->sliders()->get()): null,
        'ratesStore' =>  $this->storeRates()->count() > 0 ? RateResource::collection($this->storeRates()->get()): null,
        // 'ratesClient' =>  $this->rates()->count() > 0 ? RateResource::collection($this->rates()->get()): null,
          'stars' =>rate($this->id),
          'coupon' =>$this->coupon != null ? number_format((float)$this->coupon, 2, '.', ''):null,

        'created_at'         => $this->created_at->format('Y-m-d'),
    ];

    }
}
