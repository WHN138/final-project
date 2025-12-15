<?php
/**
 * Generate VAPID Keys for Web Push
 * 
 * Run this script once to generate your VAPID keys:
 * php generate-vapid-keys.php
 * 
 * Then add the keys to your .env file
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Minishlink\WebPush\VAPID;

echo "=== Generating VAPID Keys ===\n\n";

try {
    $keys = VAPID::createVapidKeys();
    
    echo "VAPID keys generated successfully!\n\n";
    echo "=== Public Key ===\n";
    echo $keys['publicKey'] . "\n\n";
    echo "=== Private Key ===\n";
    echo $keys['privateKey'] . "\n\n";
    echo "=== Add these to your .env file ===\n";
    echo "VAPID_PUBLIC_KEY=" . $keys['publicKey'] . "\n";
    echo "VAPID_PRIVATE_KEY=" . $keys['privateKey'] . "\n";
    echo "VAPID_SUBJECT=mailto:admin@healthyapp.com\n\n";
    echo "=== IMPORTANT ===\n";
    echo "Keep your private key secret!\n";
    echo "The public key will be used in the client-side JavaScript.\n";
    
} catch (Exception $e) {
    echo "Error generating VAPID keys: " . $e->getMessage() . "\n";
    exit(1);
}

exit(0);
?>
