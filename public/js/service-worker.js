// service-worker.js

// Nom du cache et fichiers à mettre en cache
const CACHE_NAME = 'laravel-pwa-cache-v1';
const urlsToCache = [
  '/', '/css/app.css', '/css/caisse.css', '/js/app.js', '/images/logo.png', 
  // Ajoutez ici d'autres ressources statiques à mettre en cache
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(urlsToCache);
      })
  );
});

// Événement fetch pour gérer les requêtes réseau
self.addEventListener('fetch', (event) => {
  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // Si la requête réussit, on la retourne
        return response;
      })
      .catch((error) => {
        // Si la requête échoue (probablement en mode hors ligne), on l'enregistre en local
        if (event.request.method === "POST" || event.request.method === "PUT" || event.request.method === "DELETE") {
          storeRequestLocally(event.request); // Stockage des requêtes modifiées
        }
        
        return caches.match(event.request);
      })
  );
});

// Fonction pour stocker les requêtes dans IndexedDB
function storeRequestLocally(request) {
  const dbPromise = indexedDB.open('offline-requests-db', 1);

  dbPromise.onupgradeneeded = function(event) {
    const db = event.target.result;
    if (!db.objectStoreNames.contains('requests')) {
      db.createObjectStore('requests', { keyPath: 'id', autoIncrement: true });
    }
  };

  dbPromise.onsuccess = function(event) {
    const db = event.target.result;
    const transaction = db.transaction('requests', 'readwrite');
    const store = transaction.objectStore('requests');
    store.add({ url: request.url, method: request.method, body: request.body, timestamp: Date.now() });
  };
}

// Fonction pour synchroniser les requêtes stockées avec le serveur
function syncRequests() {
  const dbPromise = indexedDB.open('offline-requests-db', 1);

  dbPromise.onsuccess = function(event) {
    const db = event.target.result;
    const transaction = db.transaction('requests', 'readonly');
    const store = transaction.objectStore('requests');

    const allRequests = store.getAll();

    allRequests.onsuccess = function() {
      const requests = allRequests.result;
      
      requests.forEach((request) => {
        fetch(request.url, {
          method: request.method,
          body: request.body
        }).then(response => {
          if (response.ok) {
            // Si la requête est réussie, on la supprime de la base locale
            deleteRequestFromDB(request.id);
          }
        }).catch(err => {
          console.error("Error syncing request:", err);
        });
      });
    };
  };
}

// Fonction pour supprimer une requête de la base de données après succès
function deleteRequestFromDB(id) {
  const dbPromise = indexedDB.open('offline-requests-db', 1);

  dbPromise.onsuccess = function(event) {
    const db = event.target.result;
    const transaction = db.transaction('requests', 'readwrite');
    const store = transaction.objectStore('requests');
    store.delete(id);
  };
}
