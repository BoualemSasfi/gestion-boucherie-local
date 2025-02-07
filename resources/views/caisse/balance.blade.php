<!DOCTYPE html>
<html>
<head>
    <title>Communication Série avec JavaScript</title>
</head>
<body>
    <h1>Communication Série</h1>
    <button id="connect">Connecter au Port Série</button>
    <pre id="output"></pre>

    <script>
        const connectButton = document.getElementById('connect');
        const output = document.getElementById('output');

        connectButton.addEventListener('click', async () => {
            try {
                // Demander à l'utilisateur de sélectionner un port série
                const port = await navigator.serial.requestPort();

                // Ouvrir une connexion au port série
                await port.open({ baudRate: 9600 });

                // Créer un lecteur de flux pour lire les données du port série
                const reader = port.readable.getReader();

                // Lire les données du port série
                while (true) {
                    const { value, done } = await reader.read();
                    if (done) break;

                    // Afficher les données lues dans l'élément <pre>
                    output.textContent += new TextDecoder().decode(value);
                }

                // Fermer la connexion au port série
                await port.close();
            } catch (error) {
                console.error('Erreur de communication série :', error);
            }
        });
    </script>
</body>
</html>
