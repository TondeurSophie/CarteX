<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

//Soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Création de l'objet Carte
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

    //Création de l'objet CarteDAO
    $carteDAO = new CarteDAO($connexion);

    //Modification de la carte
    $modificationReussie = $carteDAO->modificationCarte($carte);

    //Redirection vers la page listerCartes.php avec un message
    header("Location: listerCarte.php?messageModification=" . urlencode($modificationReussie ? "La carte a été modifiée avec succès." : "Erreur lors de la modification de la carte."));
    exit();
}

//Récupération de l'ID de la carte à modifier
if (isset($_GET['id_carte'])) {
    $id_carte = $_GET['id_carte'];

    //Création de l'objet CarteDAO
    $carteDAO = new CarteDAO($connexion);

    //Récupération des informations de la carte à modifier
    $carte = $carteDAO->listerCarteparId($id_carte);

    if ($carte && !empty($carte)) {
        ?>

        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier la carte</title>
            <link rel="stylesheet" href="modifierCarte.css">
        </head>
        <body>

        <h1>Modifier la carte</h1>

        <form action="traitement_modification.php" method="post">
            <input type="hidden" name="id_carte" value="<?php echo $carte->getId_carte(); ?>">
            <input type="text" id="id" name="id" value="<?php echo $carte->getId(); ?>" required>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?php echo $carte->getName(); ?>" required>
            <label for="type">Type :</label>
            <input type="text" id="type" name="type" value="<?php echo $carte->getType(); ?>" required>
            <label for="frameType">Frame Type :</label>
            <input type="text" id="frameType" name="frameType" value="<?php echo $carte->getFrameType(); ?>" required>
            <label for="description">Description :</label>
            <input type="text" id="description" name="description" value="<?php echo $carte->getDescription(); ?>" required>
            <label for="race">Race :</label>
            <input type="text" id="race" name="race" value="<?php echo $carte->getRace(); ?>" required>
            <label for="archetype">Archetype :</label>
            <input type="text" id="archetype" name="archetype" value="<?php echo $carte->getArcheType(); ?>" required>
            <label for="ygoprodeck_url">URL :</label>
            <input type="text" id="ygoprodeck_url" name="ygoprodeck_url" value="<?php echo $carte->getYgoprodeck_url(); ?>" required>
            <label for="cards_sets">cards_sets :</label>
            <input type="text" id="cards_sets" name="cards_sets" value="<?php echo $carte->getCards_sets(); ?>" required>
            <label for="cards_images">cards_images :</label>
            <input type="text" id="cards_images" name="cards_images" value="<?php echo $carte->getCards_images(); ?>" required>
            <label for="cards_price">cards_price :</label>
            <input type="text" id="cards_price" name="cards_price" value="<?php echo $carte->getCards_price(); ?>" required>
            <input type="submit" value="Modifier la carte">
        </form>

        </body>
        </html>

        <?php
    } else {
        //Redirection avec un message si la carte n'existe pas
        header("Location: listerCarte.php?message=La carte n'existe pas");
        exit();
    }
} else {
    //Redirection avec un message si l'ID de la carte est manquant
    header("Location: listerCarte.php?message=ID de la carte manquant");
    exit();
}
?>