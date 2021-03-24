<?php

namespace App\Http\Controllers\Api\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ClientResource;
use App\Http\Resources\RateResource;
use App\Http\Resources\TransactionResource;
use App\Models\Commissions;
use App\Models\Coupon;
use App\Models\Device;
use App\Models\Point;
use App\Models\Rate;
use App\Models\Setting;
use App\Models\Transaction;
use App\Notifications\Newvisit;
use App\User;

class TransactionController extends Controller
{
    //
   
    public function readMembershipNum(Request $request){
        
              if($request->user()->type != '2'){
    $errorsLogin = ['key' => 'message',
    'value' => 'تأكد من العضوية'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
       }

        $rules = [
            'membership_num' => 'required|exists:users,membership_num',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

              $user = User::where('membership_num',$request->membership_num)->where('type','1')->first();
        return $user
             ? ApiController::respondWithSuccess(new ClientResource($user))
             : ApiController::respondWithServerErrorArray();
    }



    public function readQrcode(Request $request){
        
        if($request->user()->type != '2'){
$errorsLogin = ['key' => 'message',
'value' => 'تأكد من العضوية'
];
return ApiController::respondWithErrorClient(array($errorsLogin));
 }

  $rules = [
      'qrcode' => 'required',
  ];
  $validator = Validator::make($request->all(), $rules);
  if ($validator->fails())
      return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));






      $qrcode = $request->qrcode;
      $pieces = explode("/", $qrcode);
      $lastRecord = array_slice($pieces, -1, 1);
      $data = [];

      foreach ($lastRecord as $i => $key) {
          if ($user = User::where('phone', $key)->where('type','1')->first()) {
            return $user
            ? ApiController::respondWithSuccess(new ClientResource($user))
            : ApiController::respondWithServerErrorArray();
          }
      }



        $user = User::where('membership_num',$request->membership_num)->first();
  return $user
       ? ApiController::respondWithSuccess(new ClientResource($user))
       : ApiController::respondWithServerErrorArray();
}






/*
* add cash to user and turn cash to point 
* and take commision from store
* but status 1 when status turn to 2 this main this transation has been confirmed
*/
public function addPoints(Request $request){

    $rules = [
        'cash' => 'required|numeric',
        'user_id' =>'required|exists:users,id',
        'coupon' =>'nullable',
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails())
        return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));


$store = $request->user();
if($store->type != '2'){
    $errorsLogin = ['key' => 'message',
'value' => 'تأكد من العضوية'
];
return ApiController::respondWithErrorClient(array($errorsLogin));
}

$user = User::where('id',$request->user_id)->first();



if($request->coupon != null){
    
    $coupon = $request->coupon;
    $pieces = explode("=", $coupon);
    $lastRecord = array_slice($pieces, -1, 1);
    $data = [];
    
    foreach ($lastRecord as $i => $key) {
 
        if ($coupon = Coupon::where('id', $key)->first()) {

       if($coupon->is_used == 0 || $coupon->is_used == 1){
if($coupon->remain >= $request->cash){
    $coupon->remain = $coupon->remain - $request->cash;
    $coupon->is_used ='1';
    $coupon->save();


    $store->coupon += $request->cash;
$store->save();

if($coupon->remain == 0){
    $coupon->is_used ='2';
    $coupon->save();
}

    $lastOrderIdNum =   Transaction::where('store_id',$store->id)->orderBy('id','desc')->first();

    
    $transaction = Transaction::create([
        'user_id' =>$request->user_id,
        'store_id' =>$store->id,
        'order_number' =>$lastOrderIdNum != null ? ($lastOrderIdNum->order_number + 1) : 1 ,
        'cash' =>$request->cash,
        // 'point' => round($addThisValToPoint),
        // 'commission' => $takeCommissionFromStore,
        'coupon' => $request->cash,
        'coupon_id' =>$coupon->id,
        'status'  => '1',
    ]);
    
    $commision = Commissions::where('user_id',$store->id)->orderBy('id','desc')->first();
    if($commision->count() >0 ){
$commision->coupon = $commision->coupon  != null ?($commision->coupon + $request->cash):$request->cash;
$commision->remain  = $commision->remain - $request->cash ;
$commision->save();
    }else{

$store->coupon = $request->cash;
$store->save();


    }
    
    return $transaction
    ? ApiController::respondWithSuccess(new TransactionResource($transaction))
    : ApiController::respondWithServerErrorArray();

}else{
    $errorsLogin = ['key' => 'message',
    'value' => 'قيمة هذا الكوبون لا  تكفي لاتمام هذه العملية'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));

}
       }else{
        if($store->type != '2'){
            $errorsLogin = ['key' => 'message',
        'value' => 'تم استخدام هذا الكوبون من قبل '
        ];
        return ApiController::respondWithErrorClient(array($errorsLogin));
        }
       }
        }
    }
}

$lastOrderIdNum =   Transaction::where('store_id',$store->id)->orderBy('id','desc')->first();


$point_equal_SR =  $store->point_equal_SR;
$commission = $store->commission;



$point = $request->cash / $point_equal_SR ;
$takeCommissionFromStore =  ($request->cash * $commission) /100 ;
$client_cashFromDashboard  = Setting::find(1)->client_cash;
$addClientCashToPoint  = ($takeCommissionFromStore * $client_cashFromDashboard) /100 ;
$addThisValToPoint  = ($addClientCashToPoint / $point_equal_SR )  + $point ;

$transaction = Transaction::create([
    'user_id' =>$request->user_id,
    'store_id' =>$store->id,
    'order_number' =>$lastOrderIdNum != null ? ($lastOrderIdNum->order_number + 1) : 1 ,
    'cash' =>$request->cash,
    'point' => round($addThisValToPoint),
    'commission' => $takeCommissionFromStore,
    'status'  => '1',
]);



return $transaction
? ApiController::respondWithSuccess(new TransactionResource($transaction))
: ApiController::respondWithServerErrorArray();

}



/*
*confirm transaction to complete this process
*/
public function confirmTransaction(Request $request){

    $rules = [
        'transaction_id' => 'required|exists:transactions,id',
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails())
        return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));



$transaction  = Transaction::where('id',$request->transaction_id)->first();
if($transaction->status == '2'){
    $errorsLogin = ['key' => 'message',
    'value' => 'تم تأكيد هذه العمليه بالفعل'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
}
$transaction->update(['status'=>'2']);
 $lastPoint = Point::where('user_id',$transaction->user_id)->orderBy('id','desc')->first();
Point::create([
    'user_id' =>$transaction->user_id ,
    'status'  => 1,
    'main'    =>  $lastPoint != null ? $lastPoint->main +$transaction->point: $transaction->point,
    'remain'   => $lastPoint != null ? $lastPoint->remain +$transaction->point : $transaction->point,
]);
//                         send notification to drivers
$devicesTokens = Device::where('user_id', $transaction->user_id)
->get()
->pluck('device_token')
->toArray();

if ($devicesTokens) {

sendMultiNotification( 'تم اضافه  ',  '  تم اضافه النقاط لحسابك'. $transaction->point .' نقطة لحسابك' ,$devicesTokens);
}
saveNotification('   تم اضافه  '   ,  '  تم اضافه نقاط لحسابك  '. $transaction->point .'   برجاء التقييم '  . ' '. '  نقطة لحسابك    ', $transaction->user_id);
return $transaction
? ApiController::respondWithSuccess(new TransactionResource($transaction))
: ApiController::respondWithServerErrorArray();

}


/*
* rate fun
* take rate 1:5 
* take transaction_id  
* take comment : null
*/
public function clientRate(Request $request){

    $rules = [
        'transaction_id' => 'required|exists:transactions,id',
        'rate' => 'required|in:1,2,3,4,5',
        'description' => 'nullable|string|max:225:min:10',
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails())
        return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));



        $transaction = Transaction::where('id',$request->transaction_id)->first();
        if($transaction->status != '2'){
            $errorsLogin = ['key' => 'message',
            'value' => 'يجب تأكيد العملية من قبل المتجر قبل التقييم'
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }  
 if($transaction->rates()->count() >= 1){
    $errorsLogin = ['key' => 'message',
    'value' => 'لا يمكن تقييم نفس العملية اكتر من مرة'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
 }
$user = $request->user();
if($user->type != '1'){
    $errorsLogin = ['key' => 'message',
    'value' => 'تأكد من العضوية'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
}
 
$rate = Rate::create([
    'rate' =>$request->rate,
    'description' =>$request->description,
    'user_id' =>$user->id,
    'transaction_id' => $request->transaction_id,
    'store_id'  => $transaction->store_id ,
]);


return $rate
? ApiController::respondWithSuccess(new RateResource($rate))
: ApiController::respondWithServerErrorArray();


}

/*
* all transaction (orders)
*/
public function allOrder(Request $request){
$user = $request->user();
if($user->type ==  '2'){

$transaction = Transaction::where('store_id',$user->id)
->where('status','2')
->orderBy('id','desc')->get();

return $transaction
? ApiController::respondWithSuccess(TransactionResource::collection($transaction))
: ApiController::respondWithServerErrorArray();
}elseif($user->type == '1'){
    $transaction = Transaction::where('user_id',$user->id)
    ->where('status','2')
    ->orderBy('id','desc')->get();

    return $transaction
? ApiController::respondWithSuccess(TransactionResource::collection($transaction))
: ApiController::respondWithServerErrorArray();
}
}
}
