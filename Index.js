// Index.js

const express = require('express');
const app = express();
const port = 3008;
const cors = require('cors');
const mysql = require('mysql');
// Import .env variables
require('dotenv').config();

app.use(cors());
app.use(express.json());

const connection = mysql.createConnection({
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    port : process.env.DB_PORT,
    host: process.env.DB_HOST,
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
