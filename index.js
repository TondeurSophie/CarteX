
// //connexion BDD
// app.get('/cartes', async(req,res) => {
//     let conn;
//     try{
//         console.log("Lancement de la connexion")
//         conn = await pool.getConnection();
//         console.log("Lancement de la requête")
//         //je renvoie toute la table cartes
//         const rows = await conn.query('select * from cartes');
//         console.log(rows);
//         res.status(200).json(rows);
//     }
//     catch(err){
//         console.log(err);
//     }
// })

// // --------Utilisateurs----------

// //récupérer toutes les informations de tous les utilisateurs
// app.get('/utilisateurs', async(req, res) => {
//     let conn;
//     try {
//         conn = await pool.getConnection();
//         const rows = await conn.query('SELECT * FROM utilisateurs');
//         res.json(rows);
//     } catch (err) {
//         console.error('Erreur lors de la récupération des utilisateurs:' + err.message);
//         res.status(500).json({ error: 'Erreur interne du serveur' });
//     } finally {
//         if (conn) conn.release();
//     }
// });

// //affichage des infos de l'utilisateur connecté
// // app.get('/utilisateurs/:id', async (req, res) => {
// //     const id_conn = req.params.id;
// //     console.log(id_conn)
// //     let conn;
// //     try {
// //         conn = await pool.getConnection();
// //         //je renvoie tous les éléments de la table locations lorsque l'id_utilisateur correspond à l'id de l'utilisateur qui c'est connecté
// //         const rows = await conn.query('SELECT pseudo, mail FROM utilisateurs WHERE id = ?;', [id_conn]);
// //         console.log("connexion",rows)
// //         if (rows.length > 0) {
// //             res.status(200).json(rows);
// //             console.log(rows)
// //         } else {
// //             res.status(404).json({ error: 'Article not found' });
// //         }
// //     } catch (err) {
// //         console.log(err);
// //         res.status(500).json({ error: 'Internal Server Error' });
// //     } finally {
// //         if (conn) conn.release();
// //     }
// // })





// // //supprimer utilisateur
// // app.delete('/supp_utilisateur/:id', async(req, res) => { 
// //     const id = parseInt(req.params.id)
// //     let conn;
// //     try{
// //         console.log("Lancement de la connexion")
// //         conn = await pool.getConnection();
// //         console.log("Lancement de la requête")
// //         //suppression d'un utilisateur en fonciton de son id
// //         const supp = await conn.query('delete from `utilisateurs` where `id` = ? ', [id]);
// //         console.log(supp);
// //         res.status(200).json(supp.affectedRows);
// //     }
// //     catch(err){
// //         console.log(err);
// //     }
// // })

// //modification utilisateur
// // app.put('/utilisateurModif/:id', async (req, res) => {
// //     const id = req.params.id;
// //     const {nom} = req.body;
// //     let conn;
// //     try {
// //         conn = await pool.getConnection();
// //         await conn.query(
// //             //modification de nom de la table utilisateurs en fonction de l'id
// //             'UPDATE utilisateurs SET nom = ? WHERE id = ?;',
// //             [nom,id]
// //         );
// //         res.status(200).json({ message: 'Article updated successfully' });
// //     } catch (err) {
// //         console.log(err);
// //         res.status(500).json({ error: 'Internal Server Error' });
// //     } finally {
// //         if (conn) conn.release();
// //     }
// // });


//Problème au niveau de la connexion
//je récupère bien l'utilisateur qui correspond au mail + mdp mais j'ai une erreur
//Error [ERR_HTTP_HEADERS_SENT]: Cannot set headers after they are sent to the client     
// at new NodeError (node:internal/errors:393:5)
// at ServerResponse.setHeader (node:_http_outgoing:644:11)
// at ServerResponse.header (C:\wamp\www\Projet\node_modules\express\lib\response.js:794:10)
// at ServerResponse.send (C:\wamp\www\Projet\node_modules\express\lib\response.js:174:12)
// at ServerResponse.json (C:\wamp\www\Projet\node_modules\express\lib\response.js:278:15)
// at C:\wamp\www\Projet\index.js:221:25 {
// code: 'ERR_HTTP_HEADERS_SENT'


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

const pool = mariadb.createPool({
    user: process.env.DB_USER,
    password: process.env.DB_PWD,
    database: process.env.DB_DTB,
    host: process.env.DB_HOST,
});


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



// //ajout utilisateur
// app.post('/utilisateurs', async(req, res) => {
//     // console.log("post",req);
//     let conn;
//     bcrypt.hash(req.body.mdp,10)
//         .then(async (hash) => {
//             console.log("Lancement de la connexion")
//             console.log(req.body)
//             conn = await pool.getConnection();
//             console.log("Lancement de la requête")
//             //insertion dans la table utilisateurs les données récupèrées du front
//             const rows = await conn.query('insert into utilisateurs (pseudo, mail, mdp, role) values (?,?,?,?)', [req.body.pseudo,req.body.email,hash,req.body.role]);
//             console.log(rows.affectedRows);
//             res.status(200).json(rows.affectedRows);
//         })
    
//     .catch((error) => res.status(500).json(error))
// })


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
        console.log(rows);
        res.status(200).json(rows);
    }
    catch(err){
        console.log(err);
    }
})

app.get('/api/cartes', (req, res) => {
    connection.query('SELECT * FROM cartes', (err, results) => {
        if (err) throw err;
        res.json(results);
    });
}
);

app.get('/api/cartes/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM cartes WHERE id = ?', [id], (err, results) => {
        if (err) throw err;
        res.json(results[0]);
    }
    );
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



app.listen(port, () => {
    console.log(`Serveur en écoute sur le port ${port}...`);
}
);