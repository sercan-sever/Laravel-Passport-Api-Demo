<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param string $loginUrl
     */
    public function __construct(private User $user, private string $loginUrl)
    {
        //
    }

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS', 'sercan@localkod.com'), 'Şifreniz Yenilendi')
            ->subject('Şifre Yenilendi')
            ->greeting('Şifreniz Başarıyla Yenilendi !!!')
            ->line('Merhaba ' . $this->user?->name . ',')
            ->line('Yeni Şifreniz İle Birlikte  Linke Tıklayarak Giriş Yapabilirsiniz.')
            ->action('Tekrar Giriş Yapın', route('login'))
            ->salutation('Saygılarımızla, Localkod');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
