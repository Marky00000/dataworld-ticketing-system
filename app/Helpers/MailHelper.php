<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailHelper
{
    /**
     * Determine which mailer to use based on email domain
     */
    public static function getMailerForEmail($email)
    {
        $domain = strtolower(substr(strrchr($email, "@"), 1));
        
        // Gmail domains - use Gmail mailer
        if (str_contains($domain, 'gmail.com') || str_contains($domain, 'googlemail.com')) {
            return 'gmail';
        }
        
        // All other domains - use your existing Outlook SMTP
        return 'smtp';
    }
    
    /**
     * Send email using the appropriate mailer based on recipient's email domain
     */
    public static function sendToEmail($to, $mailable)
    {
        $mailer = self::getMailerForEmail($to);
        
        Log::info('Sending email', [
            'to' => $to,
            'mailer' => $mailer,
            'domain' => substr(strrchr($to, "@"), 1)
        ]);
        
        try {
            // Send using the selected mailer
            Mail::mailer($mailer)->to($to)->send($mailable);
            
            Log::info('Email sent successfully', [
                'to' => $to,
                'mailer' => $mailer
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'to' => $to,
                'mailer' => $mailer,
                'error' => $e->getMessage()
            ]);
            
            // If Gmail fails, fallback to Outlook
            if ($mailer === 'gmail') {
                try {
                    Mail::mailer('smtp')->to($to)->send($mailable);
                    Log::info('Email sent via fallback SMTP', ['to' => $to]);
                    return true;
                } catch (\Exception $e2) {
                    Log::error('Fallback also failed', ['to' => $to]);
                }
            }
            
            return false;
        }
    }


 
        public static function getFromAddressForEmail($email)
        {
            $mailer = self::getMailerForEmail($email);
            
            if ($mailer === 'gmail') {
                return env('GMAIL_FROM_ADDRESS');
            }
            
            return env('MAIL_FROM_ADDRESS');
        }
}