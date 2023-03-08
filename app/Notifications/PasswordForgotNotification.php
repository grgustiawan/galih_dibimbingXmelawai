<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordForgotNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('adminmelawai@kinerja.com', 'Admin Melawai')
                    ->subject('Forgot Password - Kinerja')
                    ->line('We have received a request to reset the password for your Kinerja account.
                            To change your existing password, please press the button bellow:')
                    ->action('Forgot Password', url('http://127.0.0.1:8081/reset_password?token='.$this->token))
                    ->line('If you did not request that your password be reset, please disregard this
                            notice; your existing password will not be changed. Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
