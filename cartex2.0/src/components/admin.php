<?php
include("config.php");
include("Utilisateur.php");
include("UtilisateurDAO.php");

$utilisateurDAO = new UtilisateurDAO($connexion);

//Si on supprime
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
    $idUtilisateur = $_GET['id'];
    $utilisateurDAO->supprimerUtilisateurParId($idUtilisateur);
    header("Location: admin.php"); // Redirection après suppression
    exit();
}

//Récupération de la liste des utilisateurs
$utilisateurs = $utilisateurDAO->listerUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'administration</title>
</head>
<body>

<h1>Page d'administration</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php foreach ($utilisateurs as $utilisateur) : ?>
        <tr>
            <!-- affichage -->
            <td><?php echo $utilisateur['id']; ?></td>
            <td><?php echo $utilisateur['pseudo']; ?></td>
            <td><?php echo $utilisateur['mail']; ?></td>
            <td>
                <a href="modifier_utilisateur.php?id=<?php echo $utilisateur['id']; ?>">Modifier</a>
                <a href="admin.php?action=supprimer&id=<?php echo $utilisateur['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="ajouter_utilisateur.php">Ajouter un utilisateur</a>

</body>
</html>