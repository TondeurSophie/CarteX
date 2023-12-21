<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["carte_name"])) {
    //Création d'un nouvel objet Carte afin de pouvoir le rechercher
    $carte = new Carte(null, $_POST["carte_name"], null, null, null, null, null, null, null, null, null,null);

    //Création de l'objet CarteDAO
    $carteDAO = new CarteDAO($connexion);

    //Suppression de la carte
    $suppressionReussie = $carteDAO->supprimerCarte($carte);

    //Redirection
    if ($suppressionReussie) {
        header("Location: listerCartes.php?message=La carte a été supprimée avec succès");
    } else {
        header("Location: listerCartes.php?message=Echec de la suppression de la carte");
    }
    exit();
} else {
    //Redirection
    header("Location: listerCartes.php");
    exit();
}
?>
