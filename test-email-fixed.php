<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Mail;

echo "🔧 Testing with SSL verification disabled\n";
echo "==========================================\n\n";

// Force SSL verification to be disabled
config(['mail.mailers.smtp.stream' => [
    'ssl' => [
        'allow_self_signed' => true,
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]]);

$to = 'ticket-support@dataworld.com.ph';

echo "Current Configuration:\n";
echo "Host: " . config('mail.mailers.smtp.host') . "\n";
echo "Port: " . config('mail.mailers.smtp.port') . "\n";
echo "Encryption: " . config('mail.mailers.smtp.encryption') . "\n";
echo "Username: " . config('mail.mailers.smtp.username') . "\n";
echo "SSL Verify Peer: false\n";
echo "SSL Verify Name: false\n\n";

try {
    Mail::raw('This email should work with SSL verification disabled', function ($message) use ($to) {
        $message->to($to)
                ->subject('SSL Disabled Test - ' . date('Y-m-d H:i:s'));
    });
    
    echo "✅ Email sent successfully!\n";
    
} catch (\Exception $e) {
    echo "❌ Failed: " . $e->getMessage() . "\n\n";
    
    // Show what's in the config
    echo "Config dump:\n";
    print_r(config('mail.mailers.smtp'));
}