<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

//Soumission du formaulaire?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Objet carte en récupérant les données
    $carte = new Carte(
        $_POST["id"],
        $_POST["name"],
        $_POST["type"],
        $_POST["frameType"],
        $_POST["description"],
        $_POST["race"],
        $_POST["archetype"],
        $_POST["ygoprodeck_url"],
        $_POST["cards_sets"],
        $_POST["cards_images"],
        $_POST["cards_price"]
    );

    //Objet CarteDAO
    $carteDAO = new CarteDAO($connexion);

   //Modification de la carte
$modificationReussie = $carteDAO->modificationCarte($carte);

//Redirection vers la page listerCartes.php avec un message
header("Location: http://localhost/Xcart/listerCarte.php");
exit();
}
?>