<?php
include("config.php");
include("Utilisateur.php");
include("UtilisateurDAO.php");

//sécurité de la plateforme
if (isset($_COOKIE["role"]) && $_COOKIE["role"]=="utilisateur"){
    header("Location: Accueil.js");
}

$utilisateurDAO = new UtilisateurDAO($connexion);

//Si on supprime un utilisateur
if (isset($_GET["action"]) && $_GET["action"] == "Supprimer" && isset($_GET["id"])) {

    $id = intval($_GET["id"]); // Convertit en entier, renvoie 0 si ce n'est pas un nombre

    if($id > 0) {
    $utilisateur = $utilisateurDAO->getUtilisateurById($_GET["id"]);

    if($utilisateur instanceof Utilisateur) {
        $utilisateurDAO->supprimerUtilisateur($utilisateur);
    }
    else {
        echo "Utilisateur introuvable ou ID invalide";
    }
}
else {
    echo "ID invalide";
}
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
                <a href="admin.php?action=Supprimer&id=<?php echo $utilisateur['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; 
    $utilisateur = $utilisateurDAO->getUtilisateurById($_GET["id"]);
    var_dump($utilisateur); // Pour déboguer et vérifier que l'objet est bien récupéré.
    ?>
</table>

<a href="ajouter_utilisateur.php">Ajouter un utilisateur</a>

</body>
</html>