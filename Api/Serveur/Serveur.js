let http = require('http');
const https = require('https');
const Carte = require('../../carte');

let server = http.createServer(function(req, res) {
    // Définition de l'en-tête CORS
    res.setHeader('Access-Control-Allow-Origin', '*');

    if (req.url === '/api/cartes') {
        // Effectue la requête à l'API YGOProDeck
        https.get('https://db.ygoprodeck.com/api/v7/cardinfo.php', (apiRes) => {
            let data = '';

            apiRes.on('data', (chunk) => {
                data += chunk;
            });

            apiRes.on('end', () => {
                let jsonData = JSON.parse(data);
                let limitedData = jsonData.data.slice(0, 50); // Limite à 50 cartes
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ data: limitedData }));
            });

        }).on('error', (err) => {
            console.error('Error: ' + err.message);
        });

    } else if (req.url === '/api/utilisateurs') {
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ data: 'Utilisateurs' }));
    }
});

function startServer() {
    return new Promise((resolve) => {
        server.listen(3009, () => {
            console.log('Serveur en écoute sur le port 3009...');
            resolve();
        });
    });
}

module.exports = { startServer };
