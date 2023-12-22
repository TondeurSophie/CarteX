<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_carte"])) {
    $id_carte = $_POST["id_carte"];

    $carteDAO = new CarteDAO($connexion);

    //Suppression de la carte
    $suppressionReussie = $carteDAO->supprimerCarte($id_carte);

    //Messages d'erreur ou de succès
    echo $suppressionReussie ? "La carte a été supprimée avec succès." : "Erreur lors de la suppression de la carte.";
} else {
    
    echo "Erreur: Paramètres manquants.";
}
?>
