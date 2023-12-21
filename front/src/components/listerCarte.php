<?php
// Inclusion de la connexion à la base de données et des classes nécessaires
// require_once 'connexionBDD.php'; // Remplacez avec le chemin réel de votre fichier de connexion
require_once 'CarteDAO.php'; // Votre classe CarteDAO
require_once 'Carte.php'; // Votre classe Carte

$bdd = new PDO('mysql:host=localhost;dbname=cartex;charset=utf8', 'root', 'password');
// Création d'un objet CarteDAO pour interagir avec la base de données
$carteDAO = new CarteDAO($bdd); // Assurez-vous que $bdd est votre objet PDO de connexion à la base de données

// Récupération de toutes les cartes
$cartes = $carteDAO->listerCartes();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Cartes</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        body {
            font-family: sans-serif;
            background-color: #f1f1f1;
        }
        h1 {
            text-align: center;
        }
        table {
            margin: auto;
        }
        td {
            padding: 5px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 5px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        input[type=submit] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
        }        

    </style>
</head>
<body>
    <h1>Liste des Cartes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartes as $carte) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($carte['id_carte']); ?></td>
                    <td><?php echo htmlspecialchars($carte['name']); ?></td>
                    <td>
                        <!-- Bouton de suppression -->
                        <form action="supprimerCarte.php" method="POST">
                            <input type="hidden" name="id_carte" value="id_carte"/>
                            <input type="submit" value="Supprimer"/>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>