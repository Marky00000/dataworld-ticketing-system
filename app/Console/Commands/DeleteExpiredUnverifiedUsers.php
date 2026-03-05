<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteExpiredUnverifiedUsers extends Command
{
    protected $signature = 'users:delete-expired-unverified';
    protected $description = 'Delete unverified users after 2 minutes';

    public function handle()
    {
        $expiryMinutes = (int) config('auth.verification.expire', 2);
        
        // Find users who:
        // 1. Haven't verified email (email_verified_at is null)
        // 2. Created more than X minutes ago
        $expiredUsers = User::whereNull('email_verified_at')
            ->where('created_at', '<=', now()->subMinutes($expiryMinutes))
            ->get();

        $count = 0;
        foreach ($expiredUsers as $user) {
            $user->delete(); // Soft delete or permanent delete
            $count++;
            
            Log::info('Deleted expired unverified user', [
                'user_id' => $user->id,
                'email' => $user->email,
                'created_at' => $user->created_at
            ]);
        }

        $this->info("Deleted {$count} expired unverified users.");
        
        return Command::SUCCESS;
    }
}