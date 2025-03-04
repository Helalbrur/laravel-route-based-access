<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token; // ✅ Assign token to the class property
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Your Password')
            ->line('Click the button below to reset your password:')
            ->action('Reset Password', url(route('password.reset', ['token' => $this->token], false)))
            ->line('If you did not request a password reset, no further action is required.');
    }
}

?>