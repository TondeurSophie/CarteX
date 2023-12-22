<?php
require_once "Carte.php";
require_once "CarteDAO.php";
require_once "config.php";
// require_once "RechercherAjoutCarte.php";

//Initialisation de la variable pour le succès ou l'echec
$messageAjout = "";

$_GET["id"] = $_POST["id"];
//Si le formulaire a été transmis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST["id_carte"] = trim($_POST["id_carte"]);
    $_GET["id"] = trim($_POST["id"]);
    $_POST["name"] = trim($_POST["name"]);
    $_POST["type"] = trim($_POST["type"]);
    $_POST["frameType"] = trim($_POST["frameType"]);
    $_POST["description"] = trim($_POST["description"]);
    $_POST["race"] = trim($_POST["race"]);
    $_POST["archetype"] = trim($_POST["archetype"]);
    $_POST["ygoprodeck_url"] = trim($_POST["ygoprodeck_url"]);
    $_POST["cards_sets"] = trim($_POST["cards_sets"]);
    $_POST["cards_images"] = trim($_POST["cards_images"]);
    $_POST["card_price"] = trim($_POST["card_price"]);
    // $_POST["id_joueur"] = trim($_POST["id_joueur"]);

    // foreach ($_POST["id"] as $id) {
    //     $id_random = random_int(1, 100000);
    //     $id = $id_random;
    //     if ($id != empty($_POST["id"])) {
    //         $_POST["id"] = $id;
    //     }
    //     else {
    //         $_POST["id"] = $id_random;
    //     }

    // }
    //Création de l'objet Carte
    $carte = new Carte(
        $_POST["id_carte"],
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
        $_POST["card_price"],
        $_POST["id_joueur"]
    );

// Correction de l'initialisation de la variable id
$id = isset($_POST["id"]) ? $_POST["id"] : null;

// Utiliser une logique pour générer un ID si ce dernier est nul
if (empty($id)) {
    // Génération d'un ID aléatoire si nécessaire
    $id = random_int(1, 100000);
}

// Utiliser $id dans la création de l'objet Carte
$carte = new Carte(
    $_POST["id_carte"],
    $id,
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

$carteDAO = new CarteDAO($connexion);

// Ajout de la carte avec des vérifications
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ajout de la carte dans la base de données
        $ajoutReussi = $carteDAO->ajouterCarte($carte);

        // Gérer le message de succès ou d'échec ici
        $messageAjout = $ajoutReussi ? "La carte a été ajoutée avec succès." : "Erreur lors de l'ajout de la carte.";
    } catch (InvalidArgumentException $e) {
        // Gérer les exceptions spécifiques de validation ici
        $messageAjout = "Erreur lors de l'ajout de la carte : " . $e->getMessage();
    } catch (PDOException $e) {
        // En cas d'erreur PDO, afficher un message d'erreur
        $messageAjout = "Erreur lors de l'ajout de la carte : " . $e->getMessage();
    }
}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout de Carte</title>
    <link rel="stylesheet" href="../styles/ajoutcarte.css">
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>
    <h1>Ajouter une nouvelle carte</h1>
    <button onclick="goBack()">Revenir à la page précédente</button>
    <!-- Affichage du message de résultat -->
    <?php if (!empty($messageAjout)) : ?>
        <p><?php echo $messageAjout; ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter une carte -->
    <form action="AjoutCarte.php" method="POST">
        <label for="id_carte">ID de la carte:</label>
        <input type="text" id="id_carte" name="id_carte" required><br><br>

        <label for="id">ID de la carte:</label>
        <input type="display" id="id" name="id" required><br><br>

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