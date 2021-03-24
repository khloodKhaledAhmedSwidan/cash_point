<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\Setting;
use App\User;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notification:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send notification to store when he over commission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //


        $users = User::where('type','2')->where('active','1')->get();
        if($users->count()>0){
            foreach($users as $user){

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
   $max_commission =  Setting::where('id',1)->first()->max_commission;
   if($max_commission != null){
    if( $current_commissions >= $max_commission){
//                         send notification to drivers
$devicesTokens = Device::where('user_id', $user->id)
->get()
->pluck('device_token')
->toArray();

if ($devicesTokens) {

sendMultiNotification( ' يجب سداد العمولة المستحقة',' انتبه ! يجب سداد العمولة المستحقة' ,$devicesTokens);
}
saveNotification('يجب سداد العمولة المستحقة ','انتبه ! يجب سداد العمولة المستحقة',null ,  $user->id);
    }
   }


    }

            }
        }
    }
}
