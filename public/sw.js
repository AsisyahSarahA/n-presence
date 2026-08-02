const CACHE_NAME = 'npresence-piket-v1';

// Core assets to pre-cache on Service Worker installation
const PRECACHE_ASSETS = [
    '/piket/scanner',
    '/login',
    'https://cdn.tailwindcss.com',
    'https://unpkg.com/html5-qrcode',
    'https://cdn.jsdelivr.net/npm/sweetalert2@11',
    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'
];

// Install Event - Pre-cache core assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log('[SW] Pre-caching core assets...');
            return cache.addAll(PRECACHE_ASSETS).catch((err) => {
                console.warn('[SW] Pre-cache partial warning:', err);
            });
        }).then(() => self.skipWaiting())
    );
});

// Activate Event - Clean up outdated cache stores
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log('[SW] Deleting old cache:', cache);
                        return caches.delete(cache);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch Event Strategy:
// 1. Static Assets (CSS, JS, Fonts, Images) -> Stale-While-Revalidate (Fast UI load)
// 2. Navigation / HTML pages -> Network First, falling back to Cache
self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Only intercept GET requests
    if (request.method !== 'GET') return;

    const url = new URL(request.url);

    // Stale-While-Revalidate Strategy for static assets & CDNs
    if (
        request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'image' ||
        request.destination === 'font' ||
        url.hostname.includes('cdn.') ||
        url.hostname.includes('unpkg.com')
    ) {
        event.respondWith(
            caches.open(CACHE_NAME).then((cache) => {
                return cache.match(request).then((cachedResponse) => {
                    const fetchPromise = fetch(request).then((networkResponse) => {
                        if (networkResponse && networkResponse.status === 200) {
                            cache.put(request, networkResponse.clone());
                        }
                        return networkResponse;
                    }).catch(() => cachedResponse);

                    return cachedResponse || fetchPromise;
                });
            })
        );
        return;
    }

    // Network-First Strategy for HTML pages (/piket/scanner, /login, etc.)
    if (request.headers.get('accept')?.includes('text/html')) {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseClone);
                        });
                    }
                    return networkResponse;
                })
                .catch(() => {
                    console.log('[SW] Network failed. Serving from cache:', request.url);
                    return caches.match(request).then((cachedResponse) => {
                        if (cachedResponse) {
                            return cachedResponse;
                        }
                        // Fallback to piket scanner cache if available
                        return caches.match('/piket/scanner');
                    });
                })
        );
        return;
    }

    // Default Fetch Fallback
    event.respondWith(
        fetch(request).catch(() => caches.match(request))
    );
});
