<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommissionResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\MemberResource;
use App\Models\Commissions;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Member;
use App\Models\Point;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use Validator;

class ClientController extends Controller
{
    //
    public function myProfile(Request $request){
        $user = $request->user();
        if($user->type == '1'){
            $point = Point::where('user_id',$user->id)->orderBy('id','desc')->first();



            // if($point->count() > 0){
                $coupons = Coupon::where('user_id',$user->id)->where('is_used','0')->orWhere('is_used','1')->where('user_id',$user->id)->get();

$data = [];
array_push($data ,[ 
    'id' =>$point != null ? intval($point->id):null,
    'user_id' => intval($user->id),
    'user_name' => $user->name,
    'user_phone' => $user->phone ,
    'user_image'   => $user->image != null ? asset('/uploads/users/'.$user->image) :null,
    'qrcode' => 'https://api.qrserver.com/v1/create-qr-code/?data=' . url('qr-client-data/' .$user->phone),
    'user_membership_num' => $user->membership_num ,
    'main'         => $point != null ? intval($point->main):null,
    'remain'        =>$point != null ? intval($point->remain) :null,
    'cash'          => $point != null ?($point->cash != null ?number_format((float)$point->cash, 2, '.', ''):null):null,
    'min_limit_replacement'  => Setting::find(1)->min_limit_replacement != null ?intval(Setting::find(1)->min_limit_replacement):null,
    'member_id'       =>$user->member_id  != null ? intval($user->member_id): null,
    'member'       =>$user->member_id  != null ? new MemberResource(Member::where('id',$user->member_id )->first()): null,
    'coupon' =>  $coupons->count() > 0 ? CouponResource::collection($coupons) :null,
]);
return  ApiController::respondWithSuccess($data);
 

            // }
            // else{
            //     $errorsLogin = ['key' => 'message',
            //     'value' => 'لا يوجد بيانات بعد'
            //     ];
            //     return ApiController::respondWithErrorClient(array($errorsLogin));
            // }
        }
        elseif($user->type == '2'){

            // all Total sales , Total commissions ,current commissions 
            $total_sales = 0;
            $total_commissions = 0;
            $current_commissions = 0;
            $paid_commissions = 0;
$transactions = $user->storeTransactions()->get();
//  if($transactions->count() > 0){
if($transactions->count() >0){
 foreach($transactions as $transaction){
     if($transaction->status == 2) {
        $total_sales +=  $transaction->cash;
        $total_commissions += $transaction->commission;
        if($transaction->commission_is_paid == 1 &&$transaction->status == 2){
        $current_commissions += $transaction->commission;
        }elseif($transaction->commission_is_paid == 2 &&$transaction->status == 2){
            $paid_commissions += $transaction->commission;
        }
     }

 }


}
    $data = [];
    array_push($data,[
        'id' => intval($user->id),
        'name' => $user->name ,
        'phone' => $user->phone ,
        'logo'   =>  asset('/uploads/users/'.$user->logo) ,
        'membership_num' =>$user->membership_num ,
        'total_sales' =>number_format((float)$total_sales, 2, '.', '') ,
        'total_commissions' => number_format((float) $total_commissions, 2, '.', ''),
        'current_commissions' => number_format((float)$current_commissions, 2, '.', '')  ,
        'paid_commissions' => number_format((float)$paid_commissions, 2, '.', '') ,
        'coupon' => $user->coupon != null ?number_format((float)$user->coupon, 2, '.', '') :null,

        'max_commission' => Setting::where('id',1)->first()->max_commission != null ?number_format((float)Setting::where('id',1)->first()->max_commission, 2, '.', ''):null,
    ]);
    return  ApiController::respondWithSuccess($data);

//  }else{
//                 $errorsLogin = ['key' => 'message',
//                 'value' => 'لا يوجد بيانات بعد'
//                 ];
//                 return ApiController::respondWithErrorClient(array($errorsLogin));
//             }


        }
  
    }

/*
* turn points to cash money or قسيمة شراء
* type ==>> 0 choose turn them to cash
*type ==>> 1 choose turn them to قسيمة شراء
*check total point =>to complete this process or not
*/

    public function replacePoints(Request $request){
 
        $rules = [
            'type' => 'required|in:0,1',
            // 'bank_id' => 'required_if:type,==,0|exists:banks,id',
            // 'bank_account'  => 'required_if:type,==,0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
    

            $user = $request->user();
            if($user->type != '1'){
                $errorsLogin = ['key' => 'message',
                'value' => 'تأكد من العضوية'
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }
 $totalPoint = Point::where('user_id',$user->id)->orderBy('id','desc')->first();
 
 if($totalPoint == null){
    $errorsLogin = ['key' => 'message',
    'value' => 'لا يوجد نقاط لديك '
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
 }

     if(!($totalPoint->remain >= Setting::find(1)->min_limit_replacement) ){
        $errorsLogin = ['key' => 'message',
        'value' => 'لا يمكنك استبدال النقاط، لم تتجاوز الحد المسموح به للاستبدال وهو:  ' . Setting::find(1)->min_limit_replacement . 'نقطة',
        ];
        return ApiController::respondWithErrorClient(array($errorsLogin));
     }


// if client have active replacement order,stop him to ask another order yet
$allPointClientHave = Point::where('user_id',$user->id)->where('status','2')->orderBy('id','desc')->first();
if($allPointClientHave != null && $allPointClientHave->count() >0){
    $errorsLogin = ['key' => 'message',
    'value' => 'لا يمكن استبدال نقاط ويوجد طلب استبدال  نشط',
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
}

   
     // cash value 
     $client_cash = Setting::find(1)->client_cash;
 $cashValue = ( $totalPoint->remain * $client_cash ) / 100 ;


// type ==>> 0 choose turn them to cash
            if($request->type == 0 ){
                $rules = [
                    'bank_id' => 'required|exists:banks,id',
                    'bank_account'  => 'required',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails())
                    return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

                $totalPoint->update([
                    'type' => '0',  
                  'status'  => '2',
                  'pull' => $totalPoint->remain,
                  'remain'  => 0,
                //   'bank_id' => $request->bank_id,
                //   'bank_account' => $request->bank_account,
                  'cash' =>  $cashValue,
                   ]);

            $totalPoint->bank_id = $request->bank_id;
            $totalPoint->bank_account= $request->bank_account;
            $totalPoint->save();
          $message = ['key' => 'message',
                   'value' =>Country::where('id',$user->country_id)->first()->currency .' '. $cashValue.'انتظر تأكيد الادارة لعمليه تحويل النقاط .المبلغ المحول',
                   ];
                   return  ApiController::respondWithSuccess( $message);
            }
 // type ==>> 1 choose turn them to قسيمة شراء
            elseif($request->type == 1 ){
      
$now = Carbon::today();
// dd($now);
// $expired = Carbon::createFromFormat('Y.m.d', $now);
// dd($expired);
$daysToAdd = Setting::find(1)->coupon_period;
$expired = $now->addDays($daysToAdd);

$coupon = Coupon::create([
    'user_id' =>$user->id,
    'point_id'  =>$totalPoint->id,
    'main'    => $cashValue,
    'remain'   =>  $cashValue,
    'is_used'   => '0',
    'expired_at' => $expired,
]);

$totalPoint->update([
 'type' => 1,  
 'pull' => $totalPoint->remain,
 'remain'  => 0,
]);
//create new record in point with new data >> no cash 
$point = Point::create([
    'user_id' => $user->id,
    'main'    => $totalPoint->main,
    'remain'   => 0 ,
    'status'   => 1 ,

]);

return  ApiController::respondWithSuccess(new CouponResource($coupon));


            }
    }



    /*
    * for Store App.
    * Pay off commissions
    * payment type => 0 pay by bank 
    * payment type => 1 pay by myfatoora 
        * payment type => 2 pay by coupon  
    *my_fatoora => 1 mada
    *my_fatoora =>  2 myfatoora 
    */
    public function payOffCommissions(Request $request){
        $rules = [
            'payment_type' => 'required|in:0,1,2',
            'image' => 'required_if:payment_type,==,0|mimes:jpeg,jpg,png|max:3000',
            'my_fatoora' => 'required_if:payment_type,==,1|in:1,2',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
    

            $user = $request->user();
            if($user->type != '2'){
                $errorsLogin = ['key' => 'message',
                'value' => 'تأكد من العضوية'
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }

            $current_commissions = 0;
$transactions = $user->storeTransactions()->get();
 if($transactions->count() > 0){

 foreach($transactions as $transaction){
     if($transaction->status == 2) {
        if($transaction->commission_is_paid == 1 &&$transaction->status == 2){
        $current_commissions += $transaction->commission;
        }
     }

 }

 }

            if($request->payment_type == 0){
                if($user->coupon != null){
                    if($current_commissions >= $user->coupon){
                        $paidCoupon =  $user->coupon;
                        $reaminOfCurrentCommission = $current_commissions - $user->coupon;
                    $user->coupon = $current_commissions - $user->coupon;
                    $user->save();
                }
                }
               $pay_commission = Commissions::create([
                   'user_id' =>$user->id,
                   'total' => $user->coupon != null ?$reaminOfCurrentCommission :$current_commissions,
                   'coupon' => $user->coupon != null ? $paidCoupon :null,

                   'image' => UploadImage($request->image, 'paid', 'uploads/commissions'),
                   'status' => '0',
               ]);
               return ApiController::respondWithSuccess(new CommissionResource($pay_commission));
            }
            elseif($request->payment_type == 2){



 if($user->coupon != null){
if($current_commissions >= $user->coupon){
    $paidCoupon =  $user->coupon;
    $reaminOfCurrentCommission = $current_commissions - $user->coupon;
$user->coupon = $current_commissions - $user->coupon;
$user->save();




$pay_commission = Commissions::create([
    'user_id' =>$user->id,
    'total' => $user->coupon != null ?$reaminOfCurrentCommission :$current_commissions,
    'coupon' => $user->coupon != null ? $paidCoupon :null,
    'status' => '0',
]);
return ApiController::respondWithSuccess(new CommissionResource($pay_commission));


} elseif($current_commissions < $user->coupon){


    $paidCoupon =  $current_commissions;
    $reaminOfCurrentCommission = 0  ;
$user->coupon = $user->coupon - $current_commissions;
$user->save();



$pay_commission = Commissions::create([
    'user_id' =>$user->id,
    'total' => $user->coupon != null ?$reaminOfCurrentCommission :$current_commissions,
    'coupon' => $user->coupon != null ? $paidCoupon :null,
    // 'image' => UploadImage($request->image, 'paid', 'uploads/commissions'),
    'status' => '1',
]);

foreach($transactions as $transaction){
    if($transaction->status == 2) {
       if($transaction->commission_is_paid == 1 &&$transaction->status == 2){
        $transaction->commission_is_paid = '2';
        $transaction->save();
       }
    }

} 
return ApiController::respondWithSuccess(new CommissionResource($pay_commission));

}



}else{
    $errorsLogin = ['key' => 'message',
    'value' => 'تأكد من وجود رصيد في كوبونات'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
}

     

            }
          elseif($request->payment_type == 1){

            if($user->coupon != null){
                if($current_commissions >= $user->coupon){
                    $paidCoupon =  $user->coupon;
                    $reaminOfCurrentCommission = $current_commissions - $user->coupon;
                $user->coupon = $current_commissions - $user->coupon;
                $user->save();
            }
            }else{
                $reaminOfCurrentCommission =  $current_commissions;
            }





            $request->my_fatoora == 2 ? $charge = 2 : $charge = 6;

 $token = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
            // $token = "gwK91uGHI3BsXQNlOvjBO2K-8vZwdAaVq-heMEY8bLvgyRhEVBWwtormLOOV0zmKn-iC9PXzBn8XRdtrlfJnE7E69QoNllVb8cE3Sn9CRme7kxNSbJ_q-u7X58U1GI95jxW8o9lpjzuQWh5kz8cOpL3cmdEWn1xTlQPwaBcoPborEgZ35xVMeOOQp4FDgwDHYWz5MBFZcX_MaE2vy6IyAZeGUF7-MkL1ZgchjyLo2dq0ZVO3giugb6w0LBmoyQK2YJJlllFuDnJEy8B3IpnrJPTbfNXVtjKrCIDj0WILswG_Y2KZ8t3K1qtX_4L4sIqi6jLIW7XTHl37aetKWF7ru5I_DrUlanzFgCu2o9M0JcGBzSAFW1F_3UvonsSBGht6XjhzGGSxjBlhVcF7HGW6Mksoh11pc4Af2PMYZHm0PG6IRudebELIghGjrZYYkyArmAMV5QcAj5oOy9oslOG6q8VtlyzDZmGEJGkhyluYvyobQT8nHhcCTL7jM7zgMixViPuFvVuJlesto8UJv5eDjQRdqoSjhKkD_Q2HjICvr8Vqrv37D4DPpwf-oWAFiQWgGjLWGci1RdLpJpfRFAcrQn5UI3h7b8_D3z5L92aLtFp9J0BT3Rc0CRbyBmdXzwKgOStD2gYj2G_TINRiKrFiS0LYnGyqDB0hKO4gl1LXZD7mDn-f_CW1rY3O5xvecHqdkrQQhfU2PDe4e1RL29VPD7PcocZxGEm7QlcYNnWAASMrTCFw";
    //        $token = "cxu2LdP0p0j5BGna0velN9DmzKJTrx3Ftc0ptV8FmvOgoDqvXivkxZ_oqbi_XM9k7jgl3SUriQyRE2uaLWdRumxDLKTn1iNglbQLrZyOkmkD6cjtpAsk1_ctrea_MeOQCMavsQEJ4EZHnP4HoRDOTVRGvYQueYZZvVjsaOLOubLkdovx6STu9imI1zf5OvuC9rB8p0PNIR90rQ0-ILLYbaDZBoQANGND10HdF7zM4qnYFF1wfZ_HgQipC5A7jdrzOoIoFBTCyMz4ZuPPPyXtb30IfNp47LucQKUfF1ySU7Wy_df0O73LVnyV8mpkzzonCJHSYPaum9HzbvY5pvCZxPYw39WGo8pOMPUgEugtaqepILwtGKbIJR3_T5Iimm_oyOoOJFOtTukb_-jGMTLMZWB3vpRI3C08itm7ealISVZb7M3OMPPXgcss9_gFvwYND0Q3zJRPmDASg5NxRlEDHWRnlwNKqcd6nW4JJddffaX8p-ezWB8qAlimoKTTBJCe5CnjT4vNjnWlJWscvk38VNIIslv4gYpC09OLWn4rDNeoUaGXi5kONdEQ0vQcRjENOPAavP7HXtW1-Vz83jMlU3lDOoZsdEKZReNYpvdFrGJ5c3aJB18eLiPX6mI4zxjHCZH25ixDCHzo-nmgs_VTrOL7Zz6K7w6fuu_eBK9P0BDr2fpS";
            $data = "{\"PaymentMethodId\":\"$charge\",\"StoreName\": \"$user->name\",\"DisplayCurrencyIso\": \"SAR\",
                \"MobileCountryCode\":\"+966\",\"CustomerMobile\": \"$user->phone_number\",
                    \"StorePhone\": \"$user->phone\",\"InvoiceValue\":  $reaminOfCurrentCommission,\"CallBackUrl\": \"http://127.0.0.1:8000/check-status\",
                    \"ErrorUrl\": \"https://youtube.com\",\"Language\": \"ar\",\"CustomerReference\" :\"ref 1\",
                    \"CustomerCivilId\":12345678,\"UserDefinedField\": \"Custom field\",\"ExpireDate\": \"\",
                    \"CustomerAddress\" :{\"Block\":\"\",\"Street\":\"\",\"HouseBuildingNo\":\"\",\"Address\":\"\",\"AddressInstructions\":\"\"},
                    \"InvoiceItems\": [{\"ItemName\": \"$user->name\",\"Quantity\": 1,\"UnitPrice\":  $reaminOfCurrentCommission}]}";
            $fatooraRes = MyFatoorah($token, $data);
            $result = json_decode($fatooraRes);
    //        dd($token);
            if ($result->IsSuccess === true) {
                $pay_commission = Commissions::create([
                    'user_id' =>$user->id,
           
             'total' => $user->coupon != null ?$reaminOfCurrentCommission :$current_commissions,
               'coupon' => $user->coupon != null ? $paidCoupon :null,


                    'invoice' => $result->Data->InvoiceId,
                    'status' => '0',
                ]);


                
                $res = [
                    'PaymentURL' => $result->Data->PaymentURL
                ];
    
                return ApiController::respondWithSuccess($res);
            } else {
                return ApiController::respondWithServerErrorArray('حدث خطأ برجاء المحاولة لاحقا');
            }

          }

    }






    public function fatooraStatus(Request $request)
    {
//        $token = "7Fs7eBv21F5xAocdPvvJ-sCqEyNHq4cygJrQUFvFiWEexBUPs4AkeLQxH4pzsUrY3Rays7GVA6SojFCz2DMLXSJVqk8NG-plK-cZJetwWjgwLPub_9tQQohWLgJ0q2invJ5C5Imt2ket_-JAlBYLLcnqp_WmOfZkBEWuURsBVirpNQecvpedgeCx4VaFae4qWDI_uKRV1829KCBEH84u6LYUxh8W_BYqkzXJYt99OlHTXHegd91PLT-tawBwuIly46nwbAs5Nt7HFOozxkyPp8BW9URlQW1fE4R_40BXzEuVkzK3WAOdpR92IkV94K_rDZCPltGSvWXtqJbnCpUB6iUIn1V-Ki15FAwh_nsfSmt_NQZ3rQuvyQ9B3yLCQ1ZO_MGSYDYVO26dyXbElspKxQwuNRot9hi3FIbXylV3iN40-nCPH4YQzKjo5p_fuaKhvRh7H8oFjRXtPtLQQUIDxk-jMbOp7gXIsdz02DrCfQIihT4evZuWA6YShl6g8fnAqCy8qRBf_eLDnA9w-nBh4Bq53b1kdhnExz0CMyUjQ43UO3uhMkBomJTXbmfAAHP8dZZao6W8a34OktNQmPTbOHXrtxf6DS-oKOu3l79uX_ihbL8ELT40VjIW3MJeZ_-auCPOjpE3Ax4dzUkSDLCljitmzMagH2X8jN8-AYLl46KcfkBV";
        // $token = "gwK91uGHI3BsXQNlOvjBO2K-8vZwdAaVq-heMEY8bLvgyRhEVBWwtormLOOV0zmKn-iC9PXzBn8XRdtrlfJnE7E69QoNllVb8cE3Sn9CRme7kxNSbJ_q-u7X58U1GI95jxW8o9lpjzuQWh5kz8cOpL3cmdEWn1xTlQPwaBcoPborEgZ35xVMeOOQp4FDgwDHYWz5MBFZcX_MaE2vy6IyAZeGUF7-MkL1ZgchjyLo2dq0ZVO3giugb6w0LBmoyQK2YJJlllFuDnJEy8B3IpnrJPTbfNXVtjKrCIDj0WILswG_Y2KZ8t3K1qtX_4L4sIqi6jLIW7XTHl37aetKWF7ru5I_DrUlanzFgCu2o9M0JcGBzSAFW1F_3UvonsSBGht6XjhzGGSxjBlhVcF7HGW6Mksoh11pc4Af2PMYZHm0PG6IRudebELIghGjrZYYkyArmAMV5QcAj5oOy9oslOG6q8VtlyzDZmGEJGkhyluYvyobQT8nHhcCTL7jM7zgMixViPuFvVuJlesto8UJv5eDjQRdqoSjhKkD_Q2HjICvr8Vqrv37D4DPpwf-oWAFiQWgGjLWGci1RdLpJpfRFAcrQn5UI3h7b8_D3z5L92aLtFp9J0BT3Rc0CRbyBmdXzwKgOStD2gYj2G_TINRiKrFiS0LYnGyqDB0hKO4gl1LXZD7mDn-f_CW1rY3O5xvecHqdkrQQhfU2PDe4e1RL29VPD7PcocZxGEm7QlcYNnWAASMrTCFw";
//        $token = "cxu2LdP0p0j5BGna0velN9DmzKJTrx3Ftc0ptV8FmvOgoDqvXivkxZ_oqbi_XM9k7jgl3SUriQyRE2uaLWdRumxDLKTn1iNglbQLrZyOkmkD6cjtpAsk1_ctrea_MeOQCMavsQEJ4EZHnP4HoRDOTVRGvYQueYZZvVjsaOLOubLkdovx6STu9imI1zf5OvuC9rB8p0PNIR90rQ0-ILLYbaDZBoQANGND10HdF7zM4qnYFF1wfZ_HgQipC5A7jdrzOoIoFBTCyMz4ZuPPPyXtb30IfNp47LucQKUfF1ySU7Wy_df0O73LVnyV8mpkzzonCJHSYPaum9HzbvY5pvCZxPYw39WGo8pOMPUgEugtaqepILwtGKbIJR3_T5Iimm_oyOoOJFOtTukb_-jGMTLMZWB3vpRI3C08itm7ealISVZb7M3OMPPXgcss9_gFvwYND0Q3zJRPmDASg5NxRlEDHWRnlwNKqcd6nW4JJddffaX8p-ezWB8qAlimoKTTBJCe5CnjT4vNjnWlJWscvk38VNIIslv4gYpC09OLWn4rDNeoUaGXi5kONdEQ0vQcRjENOPAavP7HXtW1-Vz83jMlU3lDOoZsdEKZReNYpvdFrGJ5c3aJB18eLiPX6mI4zxjHCZH25ixDCHzo-nmgs_VTrOL7Zz6K7w6fuu_eBK9P0BDr2fpS";

$token = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
        $PaymentId = \Request::query('paymentId');
        $resData = MyFatoorahStatus($token, $PaymentId);
        $result = json_decode($resData);
        if ($result->IsSuccess === true && $result->Data->InvoiceStatus === "Paid") {
            $InvoiceId = $result->Data->InvoiceId;
            $commission = Commissions::where('invoice', $InvoiceId)->first();
            $commission->update(['status' => '1']);



            $user =  User::where('id',$commission->user_id)->first();


$transactions = $user->storeTransactions()->get();
 if($transactions->count() > 0){

 foreach($transactions as $transaction){
     if($transaction->status == 2) {

        if($transaction->commission_is_paid == 1 &&$transaction->status == 2){
            $transaction->commission_is_paid  = '2';
            $transaction->save();
        }
     }

 }
 }

            return redirect()->to('/fatoora/success');

        } else {
            return ApiController::respondWithServerErrorArray('حدث خطأ برجاء المحاولة لاحقا');
        }
    }


}
