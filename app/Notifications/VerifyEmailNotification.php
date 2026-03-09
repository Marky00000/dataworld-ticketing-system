<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use App\Helpers\MailHelper;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $activationUrl = $this->verificationUrl($notifiable);
        $expiration = (int) Config::get('auth.verification.expire', 60);
        
        // Always use ticket-support as sender regardless of mailer
        return (new MailMessage)
            ->from('ticket-support@dataworld.com.ph', 'Dataworld Support')
            ->subject('🔐 Activate Your Dataworld Support Account')
            ->view('email.welcome', [
                'user' => $this->user,
                'activationUrl' => $activationUrl,
                'expiration' => $expiration
            ]);
    }

    protected function verificationUrl($notifiable)
{
    $expireMinutes = (int) Config::get('auth.verification.expire', 60);
    
    // Force Carbon to use app timezone
    $expiresAt = Carbon::now()->addMinutes($expireMinutes);
    
    \Log::info('Generating verification URL', [
        'user_id' => $notifiable->id,
        'email' => $notifiable->email,
        'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
        'expires_timestamp' => $expiresAt->timestamp,
        'current_time' => Carbon::now()->format('Y-m-d H:i:s'),
        'timezone' => config('app.timezone')
    ]);
    
    return URL::temporarySignedRoute(
        'verification.verify',
        $expiresAt,
        [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]
    );
}
}