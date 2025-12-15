<?php
/**
 * Cron Job untuk mengirim meal reminders
 * 
 * Setup cron job di server:
 * - Breakfast: 0 7 * * * php /path/to/send-meal-reminders.php breakfast
 * - Lunch: 0 12 * * * php /path/to/send-meal-reminders.php lunch
 * - Dinner: 0 18 * * * php /path/to/send-meal-reminders.php dinner
 * 
 * Atau jalankan setiap menit dan cek waktu di script:
 * * * * * * php /path/to/send-meal-reminders.php auto
 */

require_once __DIR__ . '/../app/model/Notification.php';
require_once __DIR__ . '/../app/services/NotificationService.php';

// Get meal type from command line argument
$mealType = $argv[1] ?? 'auto';

$notificationModel = new Notification();
$notificationService = new NotificationService();

$currentTime = date('H:i:00');
$currentHour = (int)date('H');

// Auto mode: determine meal type based on current time
if ($mealType === 'auto') {
    if ($currentHour >= 6 && $currentHour < 11) {
        $mealType = 'breakfast';
    } elseif ($currentHour >= 11 && $currentHour < 16) {
        $mealType = 'lunch';
    } elseif ($currentHour >= 16 && $currentHour < 21) {
        $mealType = 'dinner';
    } else {
        // Outside meal times
        echo "Current time ($currentTime) is outside meal reminder times\n";
        exit(0);
    }
}

// Get users who need reminders at this time
$users = $notificationModel->getUsersForReminder($mealType, $currentTime);

if (empty($users)) {
    echo "No users found for $mealType reminder at $currentTime\n";
    exit(0);
}

echo "Found " . count($users) . " users for $mealType reminder at $currentTime\n";

$successCount = 0;
$failCount = 0;

foreach ($users as $user) {
    echo "Sending reminder to user {$user['user_id']} ({$user['email']})... ";
    
    $result = $notificationService->sendMealReminder(
        $user['user_id'],
        $user['email'],
        $user['name'],
        $mealType
    );
    
    if ($result['success']) {
        echo "SUCCESS via {$result['method']}\n";
        $successCount++;
    } else {
        echo "FAILED: {$result['message']}\n";
        $failCount++;
    }
}

echo "\n=== Summary ===\n";
echo "Total users: " . count($users) . "\n";
echo "Success: $successCount\n";
echo "Failed: $failCount\n";
echo "Meal type: $mealType\n";
echo "Time: $currentTime\n";

exit(0);
?>
