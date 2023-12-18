const http = require('http');
const serveur = require('../Serveur/Serveur');

console.log("Ceci est l'api.");

// Démarrage du serveur puis exécution du code API
serveur.startServer().then(() => {
    console.log("Ceci est l'api.");

    http.get('http://localhost:3008/api/cartes', (response) => {
        let data = '';

        response.on('data', (chunk) => {
            data += chunk;
        });

        response.on('end', () => {
            console.log(data);
        });

    }).on('error', (err) => {
        console.error('Error: ' + err.message);
    });
});


