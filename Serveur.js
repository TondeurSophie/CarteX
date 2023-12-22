// Serveur.js

let http = require('http');
const https = require('https');

let server = http.createServer(function(req, res) {
    // Vérifie si l'URL demandée est '/api/cartes'
    if (req.url === '/api/cartes') {
        // Effectue la requête à l'API YGOProDeck
        https.get('https://db.ygoprodeck.com/api/v7/cardinfo.php', (apiRes) => {
            let data = '';

            apiRes.on('data', (chunk) => {
                data += chunk;
            });

            apiRes.on('end', () => {
                // Retourne les données de l'API au client
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(data);
            });

        }).on('error', (err) => {
            console.error('Error: ' + err.message);
            res.writeHead(500);
            res.end('Internal Server Error');
        });
    } else {
        // Gestion des autres routes
        res.writeHead(404);
        res.end('Page non trouvée');
    }
});

// Modification pour retourner une promise lors du démarrage du serveur
function startServer() {
    return new Promise((resolve) => {
        server.listen(3008, () => {
            console.log('Serveur en écoute sur le port 3008...');
            resolve();
        });
    });
}

module.exports = { startServer };