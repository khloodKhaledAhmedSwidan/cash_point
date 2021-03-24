<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class Newvisit extends Notification
{
    use Queueable;
    protected $my_notification;
    public function __construct($msg)
    {
        $this->my_notification = $msg;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('السلام عليكم ورحمة الله وبركاتة ')
            ->action($this->my_notification ."  ".' استعادة كلمة مرور تطبيق كاش بوينت  ',null)
            ->line('شكرا لاستخدامكم تطبيق كاش بوينت');
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
