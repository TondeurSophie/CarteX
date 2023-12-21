
//importation d'express, cros, mariadb, bcrypt
const express = require('express');
const app = express();
const port = 3010;
const cors = require('cors');
const mariadb = require('mariadb');
const bcrypt = require('bcrypt');

// Import .env variables
require('dotenv').config();

//utilisation d'express et cors
app.use(cors());
app.use(express.json());

//connexion à la BDD grace au .env
const pool = mariadb.createPool({
    user: process.env.DB_USER,
    password: process.env.DB_PWD,
    database: process.env.DB_DTB,
    host: process.env.DB_HOST,
});

//afficher les utilisateurs
app.get('/api/utilisateurs', async (req, res) => {
    let conn;
    try {
        conn = await pool.getConnection();
        const results = await conn.query('SELECT * FROM utilisateurs');

        // Convertir les BigInt en String
        const modifiedResults = results.map(row => {
            return {
                ...row,
                id: row.id.toString(),
                role: row.role.toString(),
            };
        });

        res.json(modifiedResults);
    } catch (error) {
        console.error('Error: ' + error.message);
        res.status(500).json({ error: 'Internal Server Error' });
    } finally {
        if (conn) conn.release();
    }
});

// ajout utilisateur
app.post('/api/inscription', async (req, res) => {
    const { pseudo, mail, mdp, role } = req.body;
    let conn;
    try {
        conn = await pool.getConnection();
        //hashage du mot de passe
        mdpHashage = await bcrypt.hash(mdp,10)
        const results = await conn.query('INSERT INTO utilisateurs (pseudo, mail, mdp, role) VALUES (?, ?, ?, ?)', [pseudo, mail, mdpHashage, role]);
        res.json({ id: results.insertId });
    } catch (err) {
        console.error('Error: ' + err.message);
        res.status(500).json({ error: 'Internal Server Error' });
    } finally {
        if (conn) conn.release();
    }
});


// modification utilisateur
app.put('/api/utilisateurModif/:id', async (req, res) => {
    const id = req.params.id;
    const {pseudo} = req.body;
    let conn;
    try {
        conn = await pool.getConnection();
        await conn.query(
            //modification de pseudo de la table utilisateurs en fonction de l'id
            'UPDATE utilisateurs SET pseudo = ? WHERE id = ?;',
            [pseudo,id]
        );
        res.status(200).json({ message: 'Article updated successfully' });
    } catch (err) {
        console.log(err);
        res.status(500).json({ error: 'Internal Server Error' });
    } finally {
        if (conn) conn.release();
    }
});

// affichage des infos de l'utilisateur connecté
app.get('/utilisateurs/:id', async (req, res) => {
    const id_conn = req.params.id;
    console.log(id_conn)
    let conn;
    try {
        conn = await pool.getConnection();
        //je renvoie tous les éléments de la table locations lorsque l'id_utilisateur correspond à l'id de l'utilisateur qui c'est connecté
        const rows = await conn.query('SELECT pseudo, mail FROM utilisateurs WHERE id = ?;', [id_conn]);
        console.log("connexion",rows)
        if (rows.length > 0) {
            res.status(200).json(rows);
            console.log(rows)
        } else {
            res.status(404).json({ error: 'Article not found' });
        }
    } catch (err) {
        console.log(err);
        res.status(500).json({ error: 'Internal Server Error' });
    } finally {
        if (conn) conn.release();
    }
})

//vérification mail dans bdd
app.post('/utilisateursBDD', async(req,res) => {
    const mail = req.body.mail;
    const mdp = req.body.mdp;
    let conn;
    try{
        console.log("Lancement de la connexion")
        conn = await pool.getConnection();
        console.log("Lancement de la requête")
        //je selectionne tous de la table utilisateurs lorsque l'email correspond à l'un des "profil"
        const rows = await conn.query('select * from utilisateurs where mail = ? ', [mail]);
        console.log(rows)
        if (rows.length > 0) {
            const hash = rows[0].mdp;
            //compare mdp avec hash
            const match = await bcrypt.compare(mdp,hash);
            console.log(match);
            if (match){
                console.log("Vous êtes connecté")
                res.status(200).json({id:rows[0].id});
            }else{
                console.log("le mdp de correspond pas")
                res.status(401).json({error:"mdp incorrect"})
            }
            
        } else {
            console.log("mail non trouvé")
            res.status(404).json({ error: 'Article not found' });
        }        
        // console.log(rows);
        // res.status(200).json(rows);
    }
    catch(err){
        console.log(err);
        res.status(500).json({ error: 'Internal Server Error' });
    }
    finally {
        if (conn) {
            conn.release();
        }
    }

})

//affichage des cartes
app.get('/api/cartes', async (req, res) => {
    try {
        const conn = await pool.getConnection();
        const results = await conn.query('SELECT * FROM cartes');
        conn.release();
        res.json(results);
    } catch (error) {
        console.error('Error fetching data from database: ' + error.message);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});
//affichage des cartes en fonction de l'id
app.get('/api/cartes/:id', async (req, res) => {
    const id = req.params.id;
    try {
        const conn = await pool.getConnection();
        const results = await conn.query('SELECT * FROM cartes WHERE id_carte = ? ',[id]);
        conn.release();
        res.json(results);
    } catch (error) {
        console.error('Error fetching data from database: ' + error.message);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

// Route pour rechercher des cartes
app.get('/api/recherche/cartes', async (req, res) => {
    const searchTerm = req.query.nom; // Récupère le terme de recherche à partir de l'URL
    let conn;

    try {
        conn = await pool.getConnection();
        const query = 'SELECT * FROM cartes WHERE name LIKE ?';
        const results = await conn.query(query, [`%${searchTerm}%`]); // Utilisez % pour une recherche partielle
        res.json(results);
    } catch (error) {
        console.error('Error: ' + error.message);
        res.status(500).json({ error: 'Internal Server Error' });
    } finally {
        if (conn) conn.release();
    }
});

//ajout de cartes
app.post('/api/cartes', (req, res) => {
    const newCard = req.body;
    connection.query('INSERT INTO cartes SET ?', newCard, (err, results) => {
        if (err) throw err;
        res.status(201).json({ id: results.insertId });
    });
});

//modification cartes
app.put('/api/cartes/:id', (req, res) => {
    const id = req.params.id;
    const cardUpdates = req.body;
    connection.query('UPDATE cartes SET ? WHERE id_carte = ?', [cardUpdates, id], (err, results) => {
        if (err) throw err;
        res.json({ message: 'carte mise à jour avec succès.' });
    });
});

//suppression cartes
app.delete('/api/cartes/:id', (req, res) => {
    const id = req.params.id;
    connection.query('DELETE FROM cartes WHERE id = ?', [id], (err, results) => {
        if (err) throw err;
        res.json({ message: 'carte supprimée avec succès.' });
    });
});


//port d'écoute
app.listen(port, () => {
    console.log(`Serveur en écoute sur le port ${port}...`);
}
);