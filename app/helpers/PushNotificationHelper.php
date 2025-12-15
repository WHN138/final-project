<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationHelper
{
    private $vapidPublicKey;
    private $vapidPrivateKey;
    private $vapidSubject;

    public function __construct()
    {
        // Load from .env or config
        $this->vapidPublicKey = getenv('VAPID_PUBLIC_KEY') ?: 'YOUR_VAPID_PUBLIC_KEY';
        $this->vapidPrivateKey = getenv('VAPID_PRIVATE_KEY') ?: 'YOUR_VAPID_PRIVATE_KEY';
        $this->vapidSubject = getenv('VAPID_SUBJECT') ?: 'mailto:admin@healthyapp.com';
    }

    /**
     * Send push notification to a subscription
     */
    public function sendPush($subscriptionData, $payload)
    {
        try {
            $auth = [
                'VAPID' => [
                    'subject' => $this->vapidSubject,
                    'publicKey' => $this->vapidPublicKey,
                    'privateKey' => $this->vapidPrivateKey,
                ]
            ];

            $webPush = new WebPush($auth);

            $subscription = Subscription::create([
                'endpoint' => $subscriptionData['endpoint'],
                'keys' => [
                    'p256dh' => $subscriptionData['p256dh'],
                    'auth' => $subscriptionData['auth']
                ]
            ]);

            // Encode payload as JSON
            $payloadJson = json_encode($payload);

            $report = $webPush->sendOneNotification(
                $subscription,
                $payloadJson,
                ['TTL' => 3600] // Time to live: 1 hour
            );

            if ($report->isSuccess()) {
                return [
                    'success' => true,
                    'message' => 'Push notification sent successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Push notification failed: ' . $report->getReason(),
                    'expired' => $report->isSubscriptionExpired()
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send push to multiple subscriptions
     */
    public function sendPushToMultiple($subscriptions, $payload)
    {
        $results = [];
        
        foreach ($subscriptions as $sub) {
            $result = $this->sendPush($sub, $payload);
            $results[] = [
                'endpoint' => $sub['endpoint'],
                'result' => $result
            ];
        }

        return $results;
    }

    /**
     * Get VAPID public key for client-side
     */
    public function getPublicKey()
    {
        return $this->vapidPublicKey;
    }

    /**
     * Generate VAPID keys (run once to generate keys)
     */
    public static function generateVapidKeys()
    {
        $keys = \Minishlink\WebPush\VAPID::createVapidKeys();
        return [
            'publicKey' => $keys['publicKey'],
            'privateKey' => $keys['privateKey']
        ];
    }
}
?>
