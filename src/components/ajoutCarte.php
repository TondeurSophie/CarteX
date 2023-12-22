<?php
require_once "Carte.php";
require_once "CarteDAO.php";
// require_once "config.php";
// require_once "RechercherAjoutCarte.php";

//Initialisation de la variable pour le succès ou l'echec
$messageAjout = "";

//Si le formulaire a été transmis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Création de l'objet Carte
    $carte = new Carte(
        $_POST["id_carte"],
        $_POST["name"],
        $_POST["type"],
        $_POST["frameType"],
        $_POST["description"],
        $_POST["race"],
        $_POST["archetype"],
        $_POST["ygoprodeck_url"],
        $_POST["cards_sets"],
        $_POST["cards_images"],
        $_POST["card_price"],
        $_POST["id_joueur"]
    );

    $connexion = new PDO("mysql:host=localhost;dbname=cartex;charset=utf8", "root", "password");
    //Création du DAO pour les cartes
    $carteDAO = new CarteDAO($connexion);
    

    //Ajout de la carte
    $ajoutReussi = $carteDAO->ajouterCarte($carte);

    //Message pour succès ou echec affiché
    $messageAjout = $ajoutReussi ? "La carte a été ajoutée avec succès." : "Erreur lors de l'ajout de la carte.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout de Carte</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style type="text/css">
        label {
            display: inline-block;
            width: 150px;
            text-align: right;
        }
        input, textarea {
            margin-bottom: 5px;
        }
        button {
            margin-left: 155px;
        }
        body {
            margin: 0 auto;
            width: 800px;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Ajouter une nouvelle carte</h1>

    <!-- Affichage du message de résultat -->
    <?php if (!empty($messageAjout)) : ?>
        <p><?php echo $messageAjout; ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter une carte -->
    <form action="AjoutCarte.php" method="POST">
        <label for="id_carte">ID de la carte:</label>
        <input type="text" id="id_carte" name="id_carte" required><br><br>

        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required><br><br>

        <label for="frameType">Type de cadre:</label>
        <input type="text" id="frameType" name="frameType" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="race">Race:</label>
        <input type="text" id="race" name="race" required><br><br>

        <label for="archetype">Archétype:</label>
        <input type="text" id="archetype" name="archetype" required><br><br>

        <label for="ygoprodeck_url">URL YGOPRODeck:</label>
        <input type="text" id="ygoprodeck_url" name="ygoprodeck_url" required><br><br>

        <label for="cards_sets">Sets de cartes:</label>
        <input type="text" id="cards_sets" name="cards_sets" required><br><br>

        <label for="cards_images">Images des cartes:</label>
        <input type="text" id="cards_images" name="cards_images" required><br><br>

        <label for="card_price">Prix de la carte:</label>
        <input type="text" id="card_price" name="card_price" required><br><br>

        <button type="submit">Ajouter la carte</button>
    </form>

    <!-- <h2> Rechercher et ajouter une carte </h2>
    <form action="RechercherAjoutCarte.php" method="POST">
        <label for="recherche_carte">ID de la carte:</label>
        <input type="text" id="recherche_carte" name="recherche_carte" required><br><br>
        <button type="submit">Rechercher la carte</button> -->
</body>
</html>