// Service Worker for Push Notifications
const CACHE_NAME = 'healthy-app-v1';

// Install event
self.addEventListener('install', (event) => {
    console.log('Service Worker: Installed');
    self.skipWaiting();
});

// Activate event
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Activated');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log('Service Worker: Clearing Old Cache');
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Push event - Handle incoming push notifications
self.addEventListener('push', (event) => {
    console.log('Push notification received:', event);

    let data = {
        title: 'Healthy App',
        body: 'You have a new notification',
        icon: '/assets/images/logo-icon.png',
        badge: '/assets/images/badge-icon.png',
        tag: 'notification',
        requireInteraction: false
    };

    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data.body = event.data.text();
        }
    }

    const options = {
        body: data.body,
        icon: data.icon || '/assets/images/logo-icon.png',
        badge: data.badge || '/assets/images/badge-icon.png',
        tag: data.tag || 'notification',
        requireInteraction: data.requireInteraction || false,
        data: {
            url: data.url || '/views/dashboard.php',
            dateOfArrival: Date.now(),
            primaryKey: data.primaryKey || 1
        },
        actions: data.actions || [
            {
                action: 'open',
                title: 'Buka Aplikasi',
                icon: '/assets/images/open-icon.png'
            },
            {
                action: 'close',
                title: 'Tutup',
                icon: '/assets/images/close-icon.png'
            }
        ],
        vibrate: [200, 100, 200],
        sound: '/assets/sounds/notification.mp3'
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

// Notification click event
self.addEventListener('notificationclick', (event) => {
    console.log('Notification clicked:', event);

    event.notification.close();

    if (event.action === 'close') {
        return;
    }

    const urlToOpen = event.notification.data.url || '/views/dashboard.php';

    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then((clientList) => {
            // Check if there's already a window open
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url === urlToOpen && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, open a new window
            if (clients.openWindow) {
                return clients.openWindow(urlToOpen);
            }
        })
    );
});

// Background sync (optional - for offline support)
self.addEventListener('sync', (event) => {
    console.log('Background sync:', event);

    if (event.tag === 'sync-notifications') {
        event.waitUntil(
            // Sync logic here
            Promise.resolve()
        );
    }
});

// Fetch event (optional - for caching)
self.addEventListener('fetch', (event) => {
    // You can add caching strategy here if needed
});
