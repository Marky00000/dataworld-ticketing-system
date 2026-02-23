<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Console\Command;

class CleanExpiredUsers extends Command
{
    protected $signature = 'users:clean-expired';
    protected $description = 'Delete expired unverified users';

    public function handle(VerificationController $controller)
    {
        $deleted = $controller->cleanupExpiredUsers();
        $this->info("Deleted {$deleted} expired unverified users.");
    }
}