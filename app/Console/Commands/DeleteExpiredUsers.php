<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class DeleteExpiredUsers extends Command
{
    protected $signature = 'users:delete-expired';
    protected $description = 'Delete unverified users older than 2 minutes';

    public function handle()
    {
        $this->info('🔍 Checking for expired unverified users...');
        
        try {
            $expireMinutes = 2;
            $cutoffTime = now()->subMinutes($expireMinutes);
            
    
            $usersToDelete = User::where('user_type', User::USER_TYPE_USER)
                ->whereNull('email_verified_at')
                ->where('created_at', '<=', $cutoffTime)
                ->whereDoesntHave('createdTickets')
                ->get();
            
            $deletedCount = 0;
            $deletedEmails = [];
            
            foreach ($usersToDelete as $user) {
                // Log each deletion
                Log::info('🗑️ Deleting expired unverified user', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'registered_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'age_minutes' => now()->diffInMinutes($user->created_at)
                ]);
                
                $deletedEmails[] = $user->email;
                $user->delete();
                $deletedCount++;
            }
            
            // Find users that have tickets (skipped)
            $skippedUsers = User::where('user_type', User::USER_TYPE_USER)
                ->whereNull('email_verified_at')
                ->where('created_at', '<=', $cutoffTime)
                ->whereHas('createdTickets')
                ->withCount('createdTickets')
                ->get(['id', 'email']);
            
            // Output results
            if ($deletedCount > 0) {
                $this->info("✅ Deleted {$deletedCount} expired unverified users:");
                foreach ($deletedEmails as $email) {
                    $this->line("   - {$email}");
                }
                
                Log::info("Cleanup completed", [
                    'deleted_count' => $deletedCount,
                    'deleted_emails' => $deletedEmails
                ]);
            } else {
                $this->info("✅ No expired unverified users found to delete");
            }
            
            if ($skippedUsers->count() > 0) {
                $this->warn("⚠️ Skipped {$skippedUsers->count()} users with tickets:");
                foreach ($skippedUsers as $user) {
                    $this->warn("   - {$user->email} (has {$user->created_tickets_count} ticket(s))");
                }
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            Log::error('Delete expired users command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
}