const http = require('http');
const serveur = require('./Serveur');

console.log("Ceci est l'api.");

// Démarrage du serveur puis exécution du code API
serveur.startServer().then(() => {
    console.log("Ceci est l'api.");

    http.get('http://localhost:3001/api/cartes', (response) => {
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


app.get('/api/cartes/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM cartes WHERE id_carte = ?', [id], (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});


app.post('/api/cartes', (req, res) => {
    const newCard = req.body;
    connection.query('INSERT INTO cartes SET ?', newCard, (err, results) => {
        if (err) throw err;
        res.status(201).json({ id: results.insertId });
    });
});


app.put('/api/cartes/:id', (req, res) => {
    const id = req.params.id;
    const cardUpdates = req.body;
    connection.query('UPDATE cartes SET ? WHERE id_carte = ?', [cardUpdates, id], (err, results) => {
        if (err) throw err;
        res.json({ message: 'carte mise à jour avec succès.' });
    });
});


app.delete('/api/cartes/:id', (req, res) => {
    const id = req.params.id;
    connection.query('DELETE FROM cartes WHERE id = ?', [id], (err, results) => {
        if (err) throw err;
        res.json({ message: 'carte supprimée avec succès.' });
    });
});

