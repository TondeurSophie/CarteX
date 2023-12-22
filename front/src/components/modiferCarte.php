<?php
include_once("Carte.php");
include_once("CarteDAO.php");
include_once("config.php");

$carteDAO = new CarteDAO($connexion);

// Activer l'affichage des erreurs (pour le développement)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérification de la présence et de la validité de l'ID de la carte
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "ID de carte invalide";
    exit;
}

// Récupération de la carte
$carte = $carteDAO->listerCarteparId($_GET["id"]);

// Si la carte n'existe pas
if (!$carte || !$carte instanceof Carte) {
    echo "Carte introuvable ou ID invalide";
    exit;
}

// Initialisation de la variable pour le message de retour
$messageModification = '';

// Si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération de l'ID de la carte
    $_GET["id_carte"] = $_POST["id_carte"];
    // Création de l'objet Carte avec les informations mises à jour
    $carte = new Carte(
        $_GET["id_carte"],
        $_GET["id"],
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

    // Tentative de modification de la carte dans la base de données
    $modificationReussie = $carteDAO->modificationCarte($carte);

    // Message pour succès ou échec affiché
    $messageModification = $modificationReussie ? "La carte a été modifiée avec succès." : "Erreur lors de la modification de la carte.";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier une carte</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style type="text/css">
        label {
            display: inline-block;
            width: 150px;
            text-align: right;
        }

        input,
        textarea {
            margin-bottom: 5px;
        }

        button {
            margin-left: 155px;
        }

        body {
            background-color: #f3f3f3;
            font-family: Arial, Helvetica, sans-serif;
        }

        .box {
            background-color: #fff;
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .box h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .box p {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .box form div {
            margin-bottom: 20px;
        }

        .box form div label {
            display: block;
            margin-bottom: 5px;
        }

        .box form div input[type="text"],
        .box form div input[type="email"],
        .box form div input[type="password"] {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .box form div input[type="submit"] {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: none;
            background-color: #0067ab;
            color: #fff;
            font-weight: bold;
        }

        .box form div input[type="submit"]:hover {
            background-color: #005b9e;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="box">
        <h1>Modifier une carte</h1>

        <?php if (isset($messageModification)) : ?>
            <p><?php echo $messageModification; ?></p>
        <?php endif; ?>

        <form method="post" action="modifierCarte.php?id=<?php echo $carte->getId_carte(); ?>">
            <input type="hidden" name="id_carte" value="<?php echo $carte->getId_carte(); ?>">
            <input type="hidden" name="id" value="<?php echo $carte->getId(); ?>">
            <div>
            <label for="name">Nom de la carte</label>
            <input type="text" name="name" id="name" value="<?php echo $carte->getName(); ?>">
            </div>
            <div>
                <label for="type">Type</label>
                <input type="text" name="type" id="type" value="<?php echo $carte->getType(); ?>">
            </div>
            <div>
                <label for="frameType">FrameType</label>
                <input type="text" name="frameType" id="frameType" value="<?php echo $carte->getFrameType(); ?>">
            </div>
            <div>
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="<?php echo $carte->getDescription(); ?>">
            </div>
            <div>
                <label for="race">Race</label>
                <input type="text" name="race" id="race" value="<?php echo $carte->getRace(); ?>"
            </div>
            <div>
                <label for="archetype">Archetype</label>
                <input type="text" name="archetype" id="archetype" value="<?php echo $carte->getArcheType(); ?>">
            </div>
            <div>
                <label for="ygoprodeck_url">URL Ygoprodeck</label>
                <input type="text" name="ygoprodeck_url" id="ygoprodeck_url" value="<?php echo $carte->getYgoprodeck_url(); ?>">
            </div>
            <div>
                <label for="cards_sets">Sets de la carte</label>
                <input type="text" name="cards_sets" id="cards_sets" value="<?php echo $carte->getCards_sets(); ?>">
            </div>
            <div>
                <label for="cards_images">Images de la carte</label>
                <input type="text" name="cards_images" id="cards_images" value="<?php echo $carte->getCards_images(); ?>">
            </div>
            <div>
                <label for="cards_price">Prix de la carte</label>
                <input type="text" name="cards_price" id="cards_price" value="<?php echo $carte->getCards_price(); ?>">
            </div>
            
            
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>

</html>
