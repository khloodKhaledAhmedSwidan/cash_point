<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Point;
use App\User;
use Illuminate\Console\Command;


class UserMembers extends Command
{
       /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check  the  member points';

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
        $users = User::where('type','1')->where('active','1')->get();
        $members = Member::all();
        foreach($users as $user){
            $point = Point::where('user_id',$user->id)->orderBy('id','desc')->first();
            foreach($members as $member){
           $currentMember = $user->member_id;
           if($currentMember != null){
            $currentType = Member::find($currentMember)->type;
            if($currentType < $member->type){
                if($point->remain == $member->point || $point->remain > $member->point){
                $user->update([
                    'member_id' => $member->id,
                ]);
                }
        
            } 
           }elseif($currentMember == null){
            if($point->remain == $member->point || $point->remain > $member->point){
                $user->member_id = $member->id;
                $user->save();
                }
           }
    
            }
     
        }
    }
}
