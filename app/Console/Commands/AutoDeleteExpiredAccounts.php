<?php

namespace App\Console\Commands;

use App\Http\Controllers\AuthController;
use Illuminate\Console\Command;

class AutoDeleteExpiredAccounts extends Command
{
    protected $signature = 'users:delete-expired';
    protected $description = 'Delete unverified users older than 2 minutes';

    public function handle(AuthController $authController)
    {
        $this->info('🔍 Checking for expired unverified users...');
        
        $deletedCount = $authController->deleteExpiredUnverifiedUsers();
        
        $this->info("✅ Operation completed. Deleted {$deletedCount} users.");
        
        return Command::SUCCESS;
    }
}