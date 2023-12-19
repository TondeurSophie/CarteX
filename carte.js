// carte.js

const Sequelize = require('sequelize');

// Configuration de Sequelize
const sequelize = new Sequelize('carteX', 'root', 'paulwifi', {
  host: 'localhost',
  dialect: 'mariadb'
  
});

// Test de la connexion à la base de données
sequelize
  .authenticate()
  .then(() => {
    console.log('Connexion à la base de données établie.');
  })
  .catch((err) => {
    console.error('Erreur de connexion à la base de données:', err);
  });

module.exports = sequelize;

