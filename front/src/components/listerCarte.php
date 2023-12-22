<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cartes</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="supprimerCarte.js"></script>
</head>
<body>
    <h1>Liste des cartes</h1>

    <?php
    $carteDAO = new CarteDAO($connexion);
    $cartes = $carteDAO->listerCartes();

    //Cartes sont disponibles
    if ($cartes) {
        foreach ($cartes as $carte) {
            //Informations de chaque carte
            echo "<p>ID Carte : " . $carte['id_carte'] . "</p>";
            // echo "<p>ID Joueur : " . $carte['id_joueur'] . "</p>";
            echo "<p>Nom : " . $carte['name'] . "</p>";
            echo "<p>Type : " . $carte['type'] . "</p>";
            echo "<p>Frame Type : " . $carte['frameType'] . "</p>";
            echo "<p>Description : " . $carte['description'] . "</p>";
            echo "<p>Race : " . $carte['race'] . "</p>";
            echo "<p>Archetype : " . $carte['archetype'] . "</p>";
            echo "<p>URL Ygoprodeck : " . $carte['ygoprodeck_url'] . "</p>";
            echo "<p>Cards Sets : " . $carte['cards_sets'] . "</p>";
            echo "<p>Cards Images : " . $carte['cards_images'] . "</p>";
            echo "<p>Cards Price : " . $carte['cards_price'] . "</p>";

            //Bouton de modification avec l'ID de la carte amenant vers la modifierCarte.php
            echo "<button><a href='modifierCarte.php?id=" . $carte['id_carte'] . "'>Modifier</a></button>";
            //Bouton de suppression avec l'ID de la carte
            echo "<button class='supprimer-carte' data-id='" . $carte['id_carte'] . "'>Supprimer</button>";

            echo "<hr>";
        }
    } else {
        //Aucune carte n'est disponible
        echo "<p>Aucune carte n'est disponible.</p>";
    }
    ?>
</body>
</html>