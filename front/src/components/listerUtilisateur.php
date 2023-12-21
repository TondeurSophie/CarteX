<?php

//Inclusion de la classe UtilisateurDAO
include_once("UtilisateurDAO.php");

//Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=cartex;charset=utf8', 'root', 'password');

//Création d'un objet UtilisateurDAO pour interagir avec la base de données
$utilisateurDAO = new UtilisateurDAO($bdd);

//Récupération de tous les utilisateurs
$utilisateurs = $utilisateurDAO->listerUtilisateurs();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
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
    <h1>Liste des Utilisateurs</h1>
    <table>
        <tr>
            <th>Pseudo</th>
            <th>Adresse mail</th>
            <!-- <th>Mot de passe</th> -->
            <th>Supprimer</th>
            <th>Modifier</th>
        </tr>
        <?php
        //Affichage de tous les utilisateurs
        foreach ($utilisateurs as $utilisateur) {
            echo "<tr>";
            echo "<td>" . $utilisateur["pseudo"] . "</td>";
            echo "<td>" . $utilisateur["mail"] . "</td>";
            // echo "<td>" . $utilisateur["mdp"] . "</td>";
            echo "<td><a href='supprimerUtilisateur.php?pseudo=" . $utilisateur["pseudo"] . "'>Supprimer</a></td>";
            echo "<td><a href='modifierUtilisateur.php?pseudo=" . $utilisateur["pseudo"] . "'>Modifier</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <a href="ajoutUtilisateur.php"><input type="submit" value="Ajouter un utilisateur"></a>
</body>
</html>