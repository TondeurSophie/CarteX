<?php

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
        $_POST["card_price"]
    );

    //Création du DAO pour les cartes
    $carteDAO = new CarteDAO($connexion);

    //Ajout de la carte
    $ajoutReussi = $carteDAO->ajouterCarte($carte);

    //Message pour succès ou echec affiché
    $messageAjout = $ajoutReussi ? "La carte a été ajoutée avec succès." : "Erreur lors de l'ajout de la carte.";
}

?>