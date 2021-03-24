<?php

namespace App\Http\Controllers\Api;

use App\PaymentValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use App\User;
use App;
use Auth;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function postPayment(Request $request)
    {
//        $rules = [
//            'price' => 'required',
//        ];
//
//        $validator = Validator::make($request->all(), $rules);
//        if ($validator->fails())
//            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        $payment = PaymentValue::find(1);
        $user = User::find($request->user()->id);
        $token = "7Fs7eBv21F5xAocdPvvJ-sCqEyNHq4cygJrQUFvFiWEexBUPs4AkeLQxH4pzsUrY3Rays7GVA6SojFCz2DMLXSJVqk8NG-plK-cZJetwWjgwLPub_9tQQohWLgJ0q2invJ5C5Imt2ket_-JAlBYLLcnqp_WmOfZkBEWuURsBVirpNQecvpedgeCx4VaFae4qWDI_uKRV1829KCBEH84u6LYUxh8W_BYqkzXJYt99OlHTXHegd91PLT-tawBwuIly46nwbAs5Nt7HFOozxkyPp8BW9URlQW1fE4R_40BXzEuVkzK3WAOdpR92IkV94K_rDZCPltGSvWXtqJbnCpUB6iUIn1V-Ki15FAwh_nsfSmt_NQZ3rQuvyQ9B3yLCQ1ZO_MGSYDYVO26dyXbElspKxQwuNRot9hi3FIbXylV3iN40-nCPH4YQzKjo5p_fuaKhvRh7H8oFjRXtPtLQQUIDxk-jMbOp7gXIsdz02DrCfQIihT4evZuWA6YShl6g8fnAqCy8qRBf_eLDnA9w-nBh4Bq53b1kdhnExz0CMyUjQ43UO3uhMkBomJTXbmfAAHP8dZZao6W8a34OktNQmPTbOHXrtxf6DS-oKOu3l79uX_ihbL8ELT40VjIW3MJeZ_-auCPOjpE3Ax4dzUkSDLCljitmzMagH2X8jN8-AYLl46KcfkBV";
        $data = "{\"PaymentMethodId\":\"2\",\"CustomerName\": \"$user->name\",\"DisplayCurrencyIso\": \"SAR\", \"MobileCountryCode\":\"+966\",\"CustomerMobile\": \"01119399781\",
                \"CustomerEmail\": \"$user->email\",\"InvoiceValue\": $payment->value,\"CallBackUrl\": \"https://kushoof.net/check-status\",\"ErrorUrl\": \"https://youtube.com\",\"Language\": \"ar\",
                \"CustomerReference\" :\"ref 1\",\"CustomerCivilId\":12345678,\"UserDefinedField\": \"Custom field\",\"ExpireDate\": \"\",\"CustomerAddress\" :{\"Block\":\"\",\"Street\":\"\",\"HouseBuildingNo\":\"\",
                \"Address\":\"\",\"AddressInstructions\":\"\"},\"InvoiceItems\": [{\"ItemName\": \"$user->name\",\"Quantity\": 1,\"UnitPrice\": $payment->value}]}";
        $fatooraRes = MyFatoorah($token, $data);
        $result = json_decode($fatooraRes);
        // dd($result);
        if ($result->IsSuccess === true) {


//            return redirect($result->Data->PaymentURL);
            $user = User::find($request->user()->id);
            if ($result->IsSuccess === true) {
                $user->update([
                    'invoice_id' => $result->Data->InvoiceId
                ]);
                $all = [];
                array_push($all , [
                    'key' => 'user_converted_to_paid',
                    'payment_url' => $result->Data->PaymentURL,
                ]);
                return ApiController::respondWithSuccess($all);
            }
        }
    }

    public  function fatooraStatus(){
        $token = "7Fs7eBv21F5xAocdPvvJ-sCqEyNHq4cygJrQUFvFiWEexBUPs4AkeLQxH4pzsUrY3Rays7GVA6SojFCz2DMLXSJVqk8NG-plK-cZJetwWjgwLPub_9tQQohWLgJ0q2invJ5C5Imt2ket_-JAlBYLLcnqp_WmOfZkBEWuURsBVirpNQecvpedgeCx4VaFae4qWDI_uKRV1829KCBEH84u6LYUxh8W_BYqkzXJYt99OlHTXHegd91PLT-tawBwuIly46nwbAs5Nt7HFOozxkyPp8BW9URlQW1fE4R_40BXzEuVkzK3WAOdpR92IkV94K_rDZCPltGSvWXtqJbnCpUB6iUIn1V-Ki15FAwh_nsfSmt_NQZ3rQuvyQ9B3yLCQ1ZO_MGSYDYVO26dyXbElspKxQwuNRot9hi3FIbXylV3iN40-nCPH4YQzKjo5p_fuaKhvRh7H8oFjRXtPtLQQUIDxk-jMbOp7gXIsdz02DrCfQIihT4evZuWA6YShl6g8fnAqCy8qRBf_eLDnA9w-nBh4Bq53b1kdhnExz0CMyUjQ43UO3uhMkBomJTXbmfAAHP8dZZao6W8a34OktNQmPTbOHXrtxf6DS-oKOu3l79uX_ihbL8ELT40VjIW3MJeZ_-auCPOjpE3Ax4dzUkSDLCljitmzMagH2X8jN8-AYLl46KcfkBV";
        $PaymentId = \Request::query('paymentId');
        $resData = MyFatoorahStatus($token, $PaymentId);
        $result = json_decode($resData);
//         dd($result);
        if($result->IsSuccess === true && $result->Data->InvoiceStatus === "Paid"){
            $InvoiceId = $result->Data->InvoiceId;
            $order = App\User::where('invoice_id',$InvoiceId)->first();
            $order->update(['status'=>1]);
            return redirect()->to('/fatoora/success');
        }
    }











    public function get_payment_value()
    {
        $payment = PaymentValue::find(1);
        $success = ['key'=>'get_payment_value',
            'value'=> intval($payment->value),
        ];
        return $payment
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    }




    //get all chats
    public function get_all_chats(Request $request)
    {
        $users = Chat::whereUser_id($request->user()->id)
            ->orderBy('id' , 'desc')
            ->get();
        if ($users->count() > 0)
        {
            $data = [];
            foreach ($users->unique('chat_id') as $user) {


                array_push($data , [
                    'id'           => intval($user->chat_id),
                    'chat_id'      => $user->chat_id,
                    'user_id'      => $user->user_id == $request->user()->id ? $user->second->id:$user->user_id  ,
                    'name'         => $user->user_id == $request->user()->id ? $user->second->type == 1 ? $user->second->guest_name : $user->second->name :$user->name ,
                    'user_photo'   => $user->user_id == $request->user()->id ? asset('/uploads/users/'.$user->second->photo): $user->user_photo ,
                    'created_at'   => $user->created_at->format('Y-m-d'),
                ]);
            }
            return $users
                ? ApiController::respondWithSuccess($data)
                : ApiController::respondWithServerErrorObject();
        }else{
            $errors = ['key'=>'get_all_chats',
                'value'=> 'لا توجد محادثات'
            ];
            return ApiController::respondWithErrorClient(array($errors));
        }

    }

    //close_chat

    public function close_chat(Request $request , $chat_id)
    {

        $chats = Chat::where('chat_id',$chat_id)->get();
        if($chats)
        {
            foreach($chats as $chat){
                $chat->delete();

            }
            $data = [
                'key' => 'close_chat',
                'value' => 'تم غلق الشات '
            ];
            return  ApiController::respondWithSuccess($data);
        }

        else{
            $errors = ['key'=>'close_chat',
                'value'=> 'لا توجد محادثة'
            ];
            return ApiController::respondWithErrorClient(array($errors));
        }


    }
    public  function upload_excel_file(Request $request)
    {
        $rules = [
            'excel_file'                 => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
                Excel::import(new App\Imports\StudentImport,$request->file('excel_file'));

        $all = [];
        $data = App\ExcelStudentData::all();
        foreach ($data as $value)
        {
            array_push($all , [
                'id'  => intval($value->id),
                'civil_record' => $value->national_id,
                'name'     => $value->name,
                'created_at'  => $value->created_at->format('Y-m-d')
            ]);
        }
        foreach ($data as $value)
        {
            $value->delete();
        }
        return  ApiController::respondWithSuccess($all);
    }
}
