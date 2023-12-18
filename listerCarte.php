<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cartes</title>
    <link rel="stylesheet" href="listerCarte.css">
</head>
<body>

<h1>Liste des cartes</h1>

<!-- Afficher la liste des cartes -->
<?php 
include_once("config.php");
include_once("Carte.php");
include_once("CarteDAO.php");

//Objet carteDAO créé afin de permettre d'appeler la liste des cartes
$carteDAO = new CarteDAO($connexion);

//Récupération de la liste de toutes les cartes dans la base de données
$cartes = $carteDAO->listerCartes();
if (!empty($cartes)) : ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Frame Type</th>
                <th>Description</th>
                <th>Race</th>
                <th>Archetype</th>
                <th>URL</th>
                <th>cards_sets</th>
                <th>cards_images</th>
                <th>cards_price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartes as $carte) : ?>
                <tr>
                    <td><?php echo $carte['id_carte']; ?></td>
                    <td><?php echo $carte['name']; ?></td>
                    <td><?php echo $carte['type']; ?></td>
                    <td><?php echo $carte['frameType']; ?></td>
                    <td><?php echo $carte['description']; ?></td>
                    <td><?php echo $carte['race']; ?></td>
                    <td><?php echo $carte['archetype']; ?></td>
                    <td><?php echo $carte['ygoprodeck_url']; ?></td>
                    <td><?php echo $carte['cards_sets']; ?></td>
                    <td><?php echo $carte['cards_images']; ?></td>
                    <td><?php echo $carte['cards_price']; ?></td>
                    <td>
                        <form action="supprimerCarte.php" method="post">
                            <input type="hidden" name="carte_name" value="<?php echo $carte['name']; ?>">
                            <input type="submit" value="Supprimer">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucune carte n'a été trouvée.</p>
<?php endif; ?>

</body>
</html>