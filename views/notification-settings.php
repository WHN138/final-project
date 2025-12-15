<?php
session_start();
require_once '../app/model/Notification.php';
require_once '../app/services/NotificationService.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth-login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$notificationModel = new Notification();
$notificationService = new NotificationService();

$settings = $notificationModel->getSettings($userId);
$vapidPublicKey = $notificationService->getVapidPublicKey();

include('partial/header.php');
include('partial/loader.php');
?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php include('partial/topbar.php') ?>
    
    <div class="page-body-wrapper">
        <?php include('partial/sidebar.php') ?>
        
        <div class="page-body">
            <?php include('partial/breadcrumb.php') ?>
            
            <div class="container-fluid">
                <div class="row">
                    <!-- Notification Settings Card -->
                    <div class="col-xl-8 col-lg-10 mx-auto">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="text-white mb-0">
                                    <i class="icofont icofont-notification me-2"></i>
                                    Pengaturan Notifikasi
                                </h4>
                            </div>
                            <div class="card-body">
                                <form id="notificationSettingsForm">
                                    <!-- Push Notification Section -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">
                                            <i class="fa fa-bell text-primary me-2"></i>
                                            Push Notification
                                        </h5>
                                        
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="pushEnabled" 
                                                   name="push_enabled" value="1" 
                                                   <?php echo $settings['push_enabled'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="pushEnabled">
                                                Aktifkan Push Notification
                                            </label>
                                        </div>
                                        
                                        <div id="pushSubscriptionStatus" class="alert alert-info">
                                            <i class="fa fa-info-circle me-2"></i>
                                            <span id="subscriptionStatusText">Checking subscription status...</span>
                                        </div>
                                        
                                        <button type="button" id="subscribePushBtn" class="btn btn-primary btn-sm mb-3">
                                            <i class="fa fa-bell me-2"></i>
                                            Subscribe to Push Notifications
                                        </button>
                                    </div>

                                    <hr>

                                    <!-- Email Notification Section -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">
                                            <i class="fa fa-envelope text-primary me-2"></i>
                                            Email Notification
                                        </h5>
                                        
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="emailEnabled" 
                                                   name="email_enabled" value="1" 
                                                   <?php echo $settings['email_enabled'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="emailEnabled">
                                                Aktifkan Email Notification
                                            </label>
                                        </div>
                                        
                                        <p class="text-muted small">
                                            <i class="fa fa-info-circle me-1"></i>
                                            Email akan dikirim sebagai fallback jika push notification tidak tersedia
                                        </p>
                                    </div>

                                    <hr>

                                    <!-- Meal Reminders Section -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">
                                            <i class="fa fa-clock-o text-primary me-2"></i>
                                            Reminder Waktu Makan
                                        </h5>
                                        
                                        <!-- Breakfast -->
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="reminderBreakfast" 
                                                           name="reminder_breakfast" value="1" 
                                                           <?php echo $settings['reminder_breakfast'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="reminderBreakfast">
                                                        Reminder Sarapan
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" name="reminder_time_breakfast" 
                                                       value="<?php echo $settings['reminder_time_breakfast']; ?>">
                                            </div>
                                        </div>

                                        <!-- Lunch -->
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="reminderLunch" 
                                                           name="reminder_lunch" value="1" 
                                                           <?php echo $settings['reminder_lunch'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="reminderLunch">
                                                        Reminder Makan Siang
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" name="reminder_time_lunch" 
                                                       value="<?php echo $settings['reminder_time_lunch']; ?>">
                                            </div>
                                        </div>

                                        <!-- Dinner -->
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="reminderDinner" 
                                                           name="reminder_dinner" value="1" 
                                                           <?php echo $settings['reminder_dinner'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="reminderDinner">
                                                        Reminder Makan Malam
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" name="reminder_time_dinner" 
                                                       value="<?php echo $settings['reminder_time_dinner']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Test Notification -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">
                                            <i class="fa fa-flask text-primary me-2"></i>
                                            Test Notification
                                        </h5>
                                        
                                        <button type="button" id="testNotificationBtn" class="btn btn-outline-primary">
                                            <i class="fa fa-paper-plane me-2"></i>
                                            Kirim Test Notification
                                        </button>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save me-2"></i>
                                            Simpan Pengaturan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include('partial/footer.php') ?>
    </div>
</div>

<?php include('partial/scripts.php') ?>

<script>
    const VAPID_PUBLIC_KEY = '<?php echo $vapidPublicKey; ?>';
    let swRegistration = null;
    
    // Check if service worker and push are supported
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        initializeServiceWorker();
    } else {
        document.getElementById('subscriptionStatusText').textContent = 
            'Push notifications tidak didukung di browser ini';
        document.getElementById('pushSubscriptionStatus').className = 'alert alert-warning';
        document.getElementById('subscribePushBtn').disabled = true;
    }

    // Initialize Service Worker
    function initializeServiceWorker() {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('Service Worker registered:', registration);
                swRegistration = registration;
                checkSubscriptionStatus();
            })
            .catch(error => {
                console.error('Service Worker registration failed:', error);
                document.getElementById('subscriptionStatusText').textContent = 
                    'Gagal mendaftarkan service worker';
                document.getElementById('pushSubscriptionStatus').className = 'alert alert-danger';
            });
    }

    // Check current subscription status
    function checkSubscriptionStatus() {
        swRegistration.pushManager.getSubscription()
            .then(subscription => {
                if (subscription) {
                    document.getElementById('subscriptionStatusText').textContent = 
                        'Anda sudah subscribe ke push notifications';
                    document.getElementById('pushSubscriptionStatus').className = 'alert alert-success';
                    document.getElementById('subscribePushBtn').textContent = 'Unsubscribe';
                    document.getElementById('subscribePushBtn').onclick = unsubscribePush;
                } else {
                    document.getElementById('subscriptionStatusText').textContent = 
                        'Anda belum subscribe ke push notifications';
                    document.getElementById('pushSubscriptionStatus').className = 'alert alert-warning';
                    document.getElementById('subscribePushBtn').textContent = 'Subscribe';
                    document.getElementById('subscribePushBtn').onclick = subscribePush;
                }
            });
    }

    // Subscribe to push
    function subscribePush() {
        const applicationServerKey = urlBase64ToUint8Array(VAPID_PUBLIC_KEY);
        
        swRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: applicationServerKey
        })
        .then(subscription => {
            console.log('Push subscription:', subscription);
            
            // Send subscription to server
            const subscriptionJson = subscription.toJSON();
            
            fetch('../process/push-subscription.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'subscribe',
                    endpoint: subscriptionJson.endpoint,
                    keys: subscriptionJson.keys
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Push notification berhasil diaktifkan',
                        confirmButtonColor: '#7366ff'
                    });
                    checkSubscriptionStatus();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error saving subscription:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal menyimpan subscription: ' + error.message,
                    confirmButtonColor: '#7366ff'
                });
            });
        })
        .catch(error => {
            console.error('Error subscribing:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal subscribe: ' + error.message,
                confirmButtonColor: '#7366ff'
            });
        });
    }

    // Unsubscribe from push
    function unsubscribePush() {
        swRegistration.pushManager.getSubscription()
            .then(subscription => {
                if (subscription) {
                    const endpoint = subscription.endpoint;
                    
                    subscription.unsubscribe()
                        .then(() => {
                            // Remove from server
                            fetch('../process/push-subscription.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    action: 'unsubscribe',
                                    endpoint: endpoint
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Push notification berhasil dinonaktifkan',
                                        confirmButtonColor: '#7366ff'
                                    });
                                    checkSubscriptionStatus();
                                }
                            });
                        });
                }
            });
    }

    // Helper function to convert VAPID key
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');
        
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    // Save settings form
    document.getElementById('notificationSettingsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('../process/save-notification-settings.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pengaturan notifikasi berhasil disimpan',
                    confirmButtonColor: '#7366ff'
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal menyimpan pengaturan: ' + error.message,
                confirmButtonColor: '#7366ff'
            });
        });
    });

    // Test notification
    document.getElementById('testNotificationBtn').addEventListener('click', function() {
        fetch('../process/send-test-notification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                type: 'test'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Test notification berhasil dikirim via ' + data.method,
                    confirmButtonColor: '#7366ff'
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal mengirim test notification: ' + error.message,
                confirmButtonColor: '#7366ff'
            });
        });
    });
</script>

<?php include('partial/footer-end.php') ?>
