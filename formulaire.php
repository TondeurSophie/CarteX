<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une carte</title>
</head>
<body>

<h1>Ajouter une carte</h1>

<!-- Affichage du message de succès ou d'échec -->
<?php if (!empty($messageAjout)) : ?>
    <p><?php echo $messageAjout; ?></p>
<?php endif; ?>

<!-- Formulaire pour ajouter une carte -->
<form action="traitement_formulaire.php" method="post">
    <label for="id">ID de la carte :</label>
    <input type="text" id="id" name="id" required><br>
    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" required><br>
    <label for="type">Type :</label>
    <input type="text" id="type" name="type" required><br>
    <label for="frameType">Frame Type :</label>
    <input type="text" id="frameType" name="frameType" required><br>
    <label for="description">Description :</label>
    <input type="text" id="description" name="description" required><br>
    <label for="race">Race :</label>
    <input type="text" id="race" name="race" required><br>
    <label for="archetype">Archetype :</label>
    <input type="text" id="archetype" name="archetype" required><br>
    <label for="ygoprodeck_url">URL :</label>
    <input type="text" id="ygoprodeck_url" name="ygoprodeck_url" required><br>
    <label for="cards_sets">cards_sets:</label>
    <input type="text" id="cards_sets" name="cards_sets" required><br>
    <label for="cards_images">cards_images:</label>
    <input type="text" id="cards_images" name="cards_images" required><br>
    <label for="cards_price">cards_price:</label>
    <input type="text" id="cards_price" name="cards_price" required><br>


    <input type="submit" value="Ajouter la carte">
</form>

</body>
</html>