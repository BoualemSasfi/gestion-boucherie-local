// Configurer IndexedDB
const dbName = "CaisseBoucherie";
const storeName = "encaissements";

function openDatabase() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(dbName, 1);

        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(storeName)) {
                db.createObjectStore(storeName, { keyPath: "id", autoIncrement: true });
            }
        };

        request.onsuccess = (event) => resolve(event.target.result);
        request.onerror = (event) => reject(event.target.error);
    });
}

// Ajouter des données à IndexedDB
async function saveOfflineData(data) {
    const db = await openDatabase();
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, "readwrite");
        const store = transaction.objectStore(storeName);
        const request = store.add(data);

        request.onsuccess = () => resolve("Donnée sauvegardée hors ligne !");
        request.onerror = (event) => reject(event.target.error);
    });
}

// Lire toutes les données hors ligne
async function getOfflineData() {
    const db = await openDatabase();
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, "readonly");
        const store = transaction.objectStore(storeName);
        const request = store.getAll();

        request.onsuccess = (event) => resolve(event.target.result);
        request.onerror = (event) => reject(event.target.error);
    });
}

// Supprimer toutes les données après synchronisation
async function clearOfflineData() {
    const db = await openDatabase();
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, "readwrite");
        const store = transaction.objectStore(storeName);
        const request = store.clear();

        request.onsuccess = () => resolve("Données locales effacées !");
        request.onerror = (event) => reject(event.target.error);
    });
}

// Vérifier le statut de connexion
function updateOnlineStatus() {
    const statusElement = document.getElementById("online-status");
    if (navigator.onLine) {
        statusElement.textContent = "En ligne";
        statusElement.className = "badge bg-success";
    } else {
        statusElement.textContent = "Hors ligne";
        statusElement.className = "badge bg-danger";
    }
}

// Synchroniser les données locales avec le serveur
async function syncData() {
    if (!navigator.onLine) {
        alert("Vous êtes hors ligne, synchronisation impossible !");
        return;
    }

    const offlineData = await getOfflineData();

    if (offlineData.length === 0) {
        alert("Aucune donnée à synchroniser !");
        return;
    }

    try {
        const response = await fetch("/api/sync", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ data: offlineData }),
        });

        if (response.ok) {
            alert("Données synchronisées avec succès !");
            await clearOfflineData();
        } else {
            alert("Erreur lors de la synchronisation !");
        }
    } catch (error) {
        console.error("Erreur de synchronisation :", error);
        alert("Impossible de synchroniser les données !");
    }
}

// Écouter les changements de statut de connexion
window.addEventListener("online", updateOnlineStatus);
window.addEventListener("offline", updateOnlineStatus);

// Initialiser le statut de connexion au chargement
document.addEventListener("DOMContentLoaded", updateOnlineStatus);
