// const http = require('http');
// const serveur = require(__dirname + '/Api/Serveur/Serveur');

// import('node-fetch').then((fetch) => {
//     console.log('Fetch importé avec succès.');
// }
// ).catch((err) => {
//     console.error('Erreur lors de l\'import de fetch:', err);
//   });
// const express = require('express');
// const app = express();
// console.log("Ceci est l'api.");

// // Démarrage du serveur puis exécution du code API
// serveur.startServer().then(() => {
//     console.log("Ceci est l'api.");

//     http.get('http://localhost:3008/api/cartes', (response) => {
//         let data = '';

//         response.on('data', (chunk) => {
//             data += chunk;
//         });

//         response.on('end', () => {
//             console.log(data);
//         });

//     }).on('error', (err) => {
//         console.error('Error: ' + err.message);
//     });
// });

// http.get('http://localhost:3008/api/utilisateurs', (response) => {
//     let data = '';

//     response.on('data', (chunk) => {
//         data += chunk;
//     });

//     response.on('end', () => {
//         console.log(data);
//     });

// }).on('error', (err) => {
//     console.error('Error: ' + err.message);
// }
// );

// import('node-fetch').then((fetch) => {
//     app.get('/api/import-cartes', async (req, res) => {
//       try {
//         const response = await fetch('https://db.ygoprodeck.com/api/v7/cardinfo.php');
//         const jsonData = await response.json();
  
//         for (const carteData of jsonData.data) {
//           await Carte.findOrCreate({
//             where: { id: carteData.id },
//             defaults: {
//               name: carteData.name,
//               description: carteData.desc,
//             }
//           });
//         }
  
//         res.status(200).json({ message: 'Cartes importées avec succès dans la BDD.' });
//       } catch (error) {
//         console.error('Erreur:', error);
//         res.status(500).json({ error: 'Internal Server Error' });
//       }
//     });
//   });






