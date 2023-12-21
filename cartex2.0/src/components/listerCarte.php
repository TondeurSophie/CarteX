<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $_POST["cards_price"],
        $_POST["id_joueur"]
    );

    $carteDAO = new CarteDAO($connexion);

    $modificationReussie = $carteDAO->modificationCarte($carte);

    header("Location: listerCarte.php?messageModification=" . urlencode($modificationReussie ? "La carte a été modifiée avec succès." : "Erreur lors de la modification de la carte."));
    exit();
}
//Récupération dans l'URL
if (isset($_GET['id_carte'])) {
    $id_carte = $_GET['id_carte'];

    $carteDAO = new CarteDAO($connexion);

    $carte = $carteDAO->listerCarteparId($id_carte);

    if ($carte) {
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
            <form action="modifierCarte.php" method="post">
                <input type="hidden" name="id_carte" value="<?php echo $carte->getId_carte(); ?>">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value="<?php echo $carte->getName(); ?>" required><br>
                <label for="type">Type :</label>
                <input type="text" id="type" name="type" value="<?php echo $carte->getType(); ?>" required><br>
                <label for="frameType">Frame Type :</label>
                <input type="text" id="frameType" name="frameType" value="<?php echo $carte->getFrameType(); ?>" required><br>
                <label for="description">Description :</label>
                <input type="text" id="description" name="description" value="<?php echo $carte->getDescription(); ?>" required><br>
                <label for="race">Race :</label>
                <input type="text" id="race" name="race" value="<?php echo $carte->getRace(); ?>" required><br>
                <label for="archetype">Archetype :</label>
                <input type="text" id="archetype" name="archetype" value="<?php echo $carte->getArcheType(); ?>" required><br>
                <label for="ygoprodeck_url">URL :</label>
                <input type="text" id="ygoprodeck_url" name="ygoprodeck_url" value="<?php echo $carte->getYgoprodeck_url(); ?>" required><br>
                <label for="cards_sets">Cards Sets :</label>
                <input type="text" id="cards_sets" name="cards_sets" value="<?php echo $carte->getCards_sets(); ?>" required><br>
                <label for="cards_images">Cards Images :</label>
                <input type="text" id="cards_images" name="cards_images" value="<?php echo $carte->getCards_images(); ?>" required><br>
                <label for="cards_price">Cards Price :</label>
                <input type="text" id="cards_price" name="cards_price" value="<?php echo $carte->getCards_price(); ?>" required><br>
                <input type="submit" value="Modifier la carte">
            </form>
        </body>
        </html>
        <?php
    } else {
        //Redirection sur la page listerCarte.php avec message
        header("Location: listerCarte.php?message=La carte n'existe pas");
        exit();
    }
} else {
    //Redirection sur la page listerCarte.php avec un message erreur ou succes
    header("Location: listerCarte.php?message=ID de la carte manquant");
    exit();
}
?>