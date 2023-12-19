<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une carte</title>
</head>
<body>

<h1>Ajouter une carte</h1>

<?php
include("Carte.php");
include("CarteDAO.php");
include("config.php");

// Initialiser la variable de succès ou d'échec de l'ajout
$messageAjout = "";

//Vérification de si le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Création de l'objet Carte en fonction des données rentrées précedemment    
$carte = new Carte
(
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

    //Création CarteDAO
    $carteDAO = new CarteDAO($connexion);

    //Ajout 
    $ajoutReussi = $carteDAO->ajouterCarte($carte);

    //Message de succès ou echec
    $messageAjout = $ajoutReussi ? "La carte a été ajoutée avec succès." : "Erreur lors de l'ajout de la carte.";
}

//Afficher le message de succès ou d'échec
if (!empty($messageAjout)) {
    echo "<p>$messageAjout</p>";
}
?>

</body>
</html>
